<?php

namespace Weemen\BlogPost\ReadModel;


use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;

use Cocur\Slugify\Slugify;
use Weemen\BlogPost\Domain\BlogPost\BlogPostCreated;
use Weemen\BlogPost\Domain\BlogPost\BlogPostEdited;
use Weemen\BlogPost\Domain\BlogPost\BlogPostId;

class BlogPostPublishedSlugsTest extends ProjectorScenarioTestCase
{

    public function testItCanCreateReadModel()
    {
        $slugify    = new Slugify();
        $blogPostId = "00000000-0000-0000-0000-000000000000";
        $title      = "title";
        $content    = "content";
        $author     = "author";
        $published  = false;
        $source     = "twitter";
        $slug       = $slugify->slugify($title);

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
                ""
            ))
            ->then([
                $this->createReadModel(
                    new BlogPostId($blogPostId),
                    $title,
                    $slug
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
                    ""
                )
            ])
            ->when(new BlogPostEdited(
                new BlogPostId($blogPostId),
                $title,
                $content,
                $author,
                false,
                $source,
                ""
            ))
            ->then([
            ]);
    }

    /**
     * @param InMemoryRepository $repository
     * @return BlogPostsPublishedSlugsProjector
     */
    protected function createProjector(InMemoryRepository $repository) : BlogPostsPublishedSlugsProjector
    {
        return new BlogPostsPublishedSlugsProjector($repository);
    }

    /**
     * @param BlogPostId $blogPostId
     * @param string $title
     * @param string $slug
     * @return BlogPostsPublishedSlugs
     */
    private function createReadModel(BlogPostId $blogPostId, string $title, string $slug) : BlogPostsPublishedSlugs
    {
        $readModel = new BlogPostsPublishedSlugs($blogPostId, $title, $slug);
        return $readModel;
    }
}