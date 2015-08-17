<?php

namespace Weemen\BlogPost\Application;


use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventStore\EventStoreInterface;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use PHPUnit_Framework_MockObject_MockObject;
use Weemen\BlogPost\Application\Command\CreateBlogPost;
use Weemen\BlogPost\Application\Command\DeleteBlogPost;
use Weemen\BlogPost\Application\Command\EditBlogPost;
use Weemen\BlogPost\Domain\BlogPost\BlogPostCreated;
use Weemen\BlogPost\Domain\BlogPost\BlogPostDeleted;
use Weemen\BlogPost\Domain\BlogPost\BlogPostEdited;
use Weemen\BlogPost\Domain\BlogPost\BlogPostId;
use Weemen\BlogPost\Domain\BlogPost\BlogPostRepository;

class BlogPostCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    private $commandHandlerUuidGenerator;


    public function testCreateBlogPost()
    {
        $generator = $this->createUuidGenerator();

        $command             = new CreateBlogPost();
        $command->blogPostId = $generator->generate();
        $command->title      = 'title';
        $command->content    = 'content';
        $command->author     = 'author';
        $command->published  = false;
        $command->source     = "twitter";

        $this->scenario
            ->given([])
            ->when($command)
            ->then([
                new BlogPostCreated(
                    new BlogPostId($command->blogPostId),
                    $command->title,
                    $command->content,
                    $command->author,
                    $command->published,
                    $command->source
                )
            ]);
    }

    public function testEditBlogPost()
    {
        $blogPostId = $this->createUuidGenerator()->generate();

        $command = new EditBlogPost();
        $command->blogPostId = $blogPostId;
        $command->title      = "title2";
        $command->content    = "content2";
        $command->author     = "author2";
        $command->published  = true;
        $command->source     = "twitter";

        $this->scenario
            ->withAggregateId($blogPostId)
            ->given([
                new BlogPostCreated(
                    new BlogPostId($blogPostId),
                    "title",
                    "content",
                    "author",
                    false,
                    "mobile"
                )
            ])
            ->when($command)
            ->then([
                new BlogPostEdited(
                    new BlogPostId($blogPostId),
                    $command->title,
                    $command->content,
                    $command->author,
                    $command->published,
                    $command->source
                )
            ]);

    }

    public function testDeleteBlogPost()
    {
        $blogPostId = $this->createUuidGenerator()->generate();

        $command = new DeleteBlogPost();
        $command->blogPostId = $blogPostId;

        $this->scenario
            ->withAggregateId($blogPostId)
            ->given([
                new BlogPostCreated(
                    new BlogPostId($blogPostId),
                    "title",
                    "content",
                    "author",
                    false,
                    "mobile"
                )
            ])
            ->when($command)
            ->then([
                new BlogPostDeleted(
                    new BlogPostId($blogPostId)
                )
            ]);
    }

    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     * @return BlogPostCommandHandler
     */
    protected function createCommandHandler(EventStoreInterface $eventStore, EventBusInterface $eventBus) : BlogPostCommandHandler
    {
        return new BlogPostCommandHandler(
            new BlogPostRepository($eventStore, $eventBus),
            $this->commandHandlerUuidGenerator()
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function commandHandlerUuidGenerator() : PHPUnit_Framework_MockObject_MockObject
    {
        if (false == $this->commandHandlerUuidGenerator) {
            $this->commandHandlerUuidGenerator = $this->getMock('Broadway\UuidGenerator\Rfc4122\Version4Generator');
        }

        return $this->commandHandlerUuidGenerator;
    }

    /**
     * @return Version4Generator
     */
    protected function createUuidGenerator() : Version4Generator
    {
        return new Version4Generator();
    }
}