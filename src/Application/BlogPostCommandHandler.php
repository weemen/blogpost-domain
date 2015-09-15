<?php

namespace Weemen\BlogPost\Application;


use Broadway\CommandHandling\CommandHandler;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use Weemen\BlogPost\Application\Command\CreateBlogPost;
use Weemen\BlogPost\Application\Command\DeleteBlogPost;
use Weemen\BlogPost\Application\Command\EditBlogPost;
use Weemen\BlogPost\Domain\BlogPost\BlogPost;
use Weemen\BlogPost\Domain\BlogPost\BlogPostId;
use Weemen\BlogPost\Domain\BlogPost\BlogPostRepository;

/**
 * Class BlogPostCommandHandler
 * @package Weemen\BlogPost\Application
 */
class BlogPostCommandHandler extends CommandHandler
{
    /**
     * @var BlogPostRepository
     */
    protected $repository;

    /**
     * @var UuidGeneratorInterface
     */
    protected $uuidGenerator;

    /**
     * @param BlogPostRepository $reposittory
     * @param UuidGeneratorInterface $uuidGenerator
     */
    public function __construct(BlogPostRepository $repository, UuidGeneratorInterface $uuidGenerator)
    {
        $this->repository    = $repository;
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @param CreateBlogPost $command
     */
    public function handleCreateBlogPost(CreateBlogPost $command)
    {
        $this->repository->save(
            BlogPost::createBlogPost(
                new BlogPostId($command->blogPostId),
                $command->title,
                $command->content,
                $command->author,
                $command->published,
                $command->source,
                $command->publishDate
            )
        );
    }

    /**
     * @param EditBlogPost $command
     */
    public function handleEditBlogPost(EditBlogPost $command)
    {
        /** @var BlogPost $blogPost */
        $blogPost = $this->repository->load($command->blogPostId);
        $blogPost->editBlogPost(
            new BlogPostId($command->blogPostId),
            $command->title,
            $command->content,
            $command->author,
            $command->published,
            $command->source,
            $command->publishDate
        );
        $this->repository->save($blogPost);
    }

    /**
     * @param DeleteBlogPost $command
     */
    public function handleDeleteBlogPost(DeleteBlogPost $command)
    {
        /** @var BlogPost $blogPost */
        $blogPost = $this->repository->load($command->blogPostId);
        $blogPost->deleteBlogPost(
            new BlogPostId($command->blogPostId)
        );
        $this->repository->save($blogPost);
    }

}