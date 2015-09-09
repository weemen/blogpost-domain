<?php

namespace Weemen\BlogPost\ReadModel;


use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use DateTime;
use Weemen\BlogPost\Domain\BlogPost\BlogPostCreated;
use Weemen\BlogPost\Domain\BlogPost\BlogPostEdited;
use Weemen\BlogPost\Domain\BlogPost\BlogPostId;

class BlogPostPublishedTest extends ProjectorScenarioTestCase
{

    public function testItCanCreateReadModel()
    {
        $blogPostId = "00000000-0000-0000-0000-000000000000";
        $title      = "title";
        $content    = "content";
        $author     = "author";
        $published  = false;
        $source     = "twitter";

        $this->scenario
            ->given([new BlogPostCreated(
                new BlogPostId($blogPostId),
                $title,
                $content,
                $author,
                $published,
                $source,
                ""
            )])
            ->when(new BlogPostEdited(
                new BlogPostId($blogPostId),
                $title,
                $content,
                $author,
                true,
                $source,
                '2015-01-01 12:11:10'
            ))
            ->then([
                $this->createReadModel(
                    new BlogPostId($blogPostId),
                    $title,
                    $content,
                    $author,
                    $source,
                    new DateTime('2015-01-01 12:11:10')
                )
            ]);
    }

    public function testItCanUnpublishReadModel()
    {
        $blogPostId = "00000000-0000-0000-0000-000000000000";
        $title      = "title";
        $content    = "content";
        $author     = "author";
        $source     = "twitter";

        $this->scenario
            ->given([
                new BlogPostCreated(
                    new BlogPostId($blogPostId),
                    $title,
                    $content,
                    $author,
                    true,
                    $source,
                    '2015-01-01 12:11:10'
                )
            ])
            ->when(new BlogPostEdited(
                new BlogPostId($blogPostId),
                $title,
                $content,
                $author,
                false,
                $source,
                ''
            ))
            ->then([
            ]);
    }

    /**
     * @param InMemoryRepository $repository
     * @return BlogPostsPublishedProjector
     */
    protected function createProjector(InMemoryRepository $repository) : BlogPostsPublishedProjector
    {
        return new BlogPostsPublishedProjector($repository);
    }

    /**
     * @param BlogPostId $blogPostId
     * @param string|string $title
     * @param string|string $content
     * @param string|string $author
     * @param string $source
     * @param DateTime $publishDate
     * @return BlogPostsPublished
     */
    private function createReadModel(BlogPostId $blogPostId, string $title, string $content, string $author, string $source, DateTime $publishDate) : BlogPostsPublished
    {
        $readModel = new BlogPostsPublished($blogPostId, $title, $content, $author, $source, new DateTime('now'), $publishDate);
        return $readModel;
    }
}