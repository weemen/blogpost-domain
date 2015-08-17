<?php

namespace Weemen\BlogPost\Domain\BlogPost;


use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Weemen\BlogPost\Domain\Exception\DomainException;

/**
 * Class BlogPost
 * @package Weemen\BlogPost\Domain\BlogPost
 */
class BlogPost extends EventSourcedAggregateRoot
{
    protected $blogPostId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var author
     */
    protected $author;

    /**
     * @var bool
     */
    protected $published;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var bool
     */
    protected $deleted;

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return $this->blogPostId;
    }

    /**
     * @param BlogPostId $blogPostId
     * @param string $title
     * @param string $content
     * @param string $author
     * @param bool $published
     * @return BlogPost
     */
    public static function createBlogPost(BlogPostId $blogPostId, string $title, string $content, string $author, bool $published, string $source) : BlogPost
    {
        $blogPost = new BlogPost();
        $blogPost->apply(new BlogPostCreated($blogPostId, $title, $content, $author, $published, $source));

        return $blogPost;
    }

    /**
     * @param BlogPostCreated $event
     */
    public function applyBlogPostCreated(BlogPostCreated $event)
    {
        $this->blogPostId = $event->blogPostId();
        $this->title      = $event->title();
        $this->content    = $event->content();
        $this->author     = $event->author();
        $this->published  = $event->published();
        $this->source     = $event->source();
        $this->deleted    = false;
    }

    /**
     * @param BlogPostId $blogPostId
     * @param string $title
     * @param string $content
     * @param string $author
     * @param bool $published
     * @throws DomainException
     */
    public function editBlogPost(BlogPostId $blogPostId, string $title, string $content, string $author, bool $published, string $source)
    {
        $this->assertTitleNotEmpty($title);
        $this->assertContentNotEmpty($content);
        $this->assertAuthorNotEmpty($author);

        $this->apply(new BlogPostEdited($blogPostId, $title, $content, $author, $published, $source));
    }

    /**
     * @param BlogPostEdited $event
     */
    public function applyBlogPostEdited(BlogPostEdited $event)
    {
        $this->blogPostId = $event->blogPostId();
        $this->title      = $event->title();
        $this->content    = $event->content();
        $this->author     = $event->author();
        $this->published  = $event->published();
        $this->source     = $event->source();
    }

    /**
     * @param BlogPostId $blogPostId
     */
    public function deleteBlogPost(BlogPostId $blogPostId)
    {
        $this->apply(new BlogPostDeleted($blogPostId));
    }

    /**
     * @param BlogPostDeleted $event
     */
    public function applyBlogPostDeleted(BlogPostDeleted $event)
    {
        $this->published    = false;
        $this->deleted      = true;
    }

    /**
     * @param string $title
     * @throws DomainException
     */
    private function assertTitleNotEmpty(string $title)
    {
        if (empty($title)) {
            throw new DomainException("Blog post title cannot be empty");
        }
    }

    /**
     * @param string $content
     * @throws DomainException
     */
    private function assertContentNotEmpty(string $content)
    {
        if (empty($content)) {
            throw new DomainException("Blog post content cannot be empty");
        }
    }

    /**
     * @param string $author
     * @throws DomainException
     */
    private function assertAuthorNotEmpty(string $author)
    {
        if (empty($author)) {
            throw new DomainException("Blog post author cannot be empty");
        }
    }
}