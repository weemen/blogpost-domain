<?php

namespace Weemen\BlogPost\ReadModel;


use Broadway\ReadModel\Projector;
use Broadway\ReadModel\RepositoryInterface;
use DateTime;
use Weemen\BlogPost\Domain\BlogPost\BlogPostCreated;
use Weemen\BlogPost\Domain\BlogPost\BlogPostDeleted;
use Weemen\BlogPost\Domain\BlogPost\BlogPostEdited;

/**
 * Class BlogPostsPublishedProjector
 * @package Weemen\BlogPost\ReadModel
 */
class BlogPostsPublishedProjector extends Projector
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
        $this->publishBlogPost($event);
    }

    /**
     * @param BlogPostEdited $event
     */
    public function applyBlogPostEdited(BlogPostEdited $event)
    {
        $this->publishBlogPost($event);
    }

    protected function publishBlogPost($event)
    {
        if (false === $event->published()) {
            $this->repository->remove((string) $event->blogPostId());
            return;
        }

        $publishDate = \DateTime::createFromFormat('Y-m-d H:i:s',$event->publishDate());

        $readModel = new BlogPostsPublished(
            $event->blogPostId(),
            $event->title(),
            $event->content(),
            $event->author(),
            $event->source(),
            new DateTime('now'),
            $publishDate->getTimestamp()
        );

        $this->repository->save($readModel);
    }

    /**
     * @param BlogPostDeleted $event
     */
    public function applyBlogPostDeleted(BlogPostDeleted $event)
    {
        $this->repository->remove((string) $event->blogPostId());
    }
}