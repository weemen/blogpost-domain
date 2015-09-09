<?php

namespace Weemen\BlogPost\ReadModel;

use Broadway\ReadModel\RepositoryInterface;
use Broadway\ReadModel\Projector;
use Cocur\Slugify\Slugify;
use Weemen\BlogPost\Domain\BlogPost\BlogPostCreated;
use Weemen\BlogPost\Domain\BlogPost\BlogPostEdited;

class BlogPostsPublishedSlugsProjector extends Projector
{

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param BlogPostCreated $event
     */
    public function applyBlogPostCreated(BlogPostCreated $event)
    {
        $this->slugifyBlogPost($event);
    }

    /**
     * @param BlogPostEdited $event
     */
    public function applyBlogPostEdited(BlogPostEdited $event)
    {
        $this->slugifyBlogPost($event);
    }

    protected function slugifyBlogPost($event)
    {
        if (false === $event->published()) {
            $this->repository->remove((string) $event->blogPostId());
            return;
        }

        $slugify   = new Slugify();
        $readModel = new BlogPostsPublishedSlugs(
            $event->blogPostId(),
            $event->title(),
            $slugify->slugify($event->title())
        );

        $this->repository->save($readModel);
    }
}