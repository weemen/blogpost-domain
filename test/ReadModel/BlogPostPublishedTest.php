<?php

namespace Weemen\BlogPost\ReadModel;


use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
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
                $source
            )])
            ->when(new BlogPostEdited(
                new BlogPostId($blogPostId),
                $title,
                $content,
                $author,
                true,
                $source
            ))
            ->then([
                $this->createReadModel(
                    new BlogPostId($blogPostId),
                    $title,
                    $content,
                    $author,
                    $source
                )
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
     * @param string $title
     * @param string $content
     * @param string $author
     * @return BlogPostsPublished
     */
    private function createReadModel(BlogPostId $blogPostId, string $title, string $content, string $author, string $source) : BlogPostsPublished
    {
        $readModel = new BlogPostsPublished($blogPostId, $title, $content, $author, $source, new \DateTime('now'));
        return $readModel;
    }
}