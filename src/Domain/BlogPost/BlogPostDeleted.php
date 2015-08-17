<?php

namespace Weemen\BlogPost\Domain\BlogPost;


class BlogPostDeleted
{

    /**
     * @var BlogPostId
     */
    protected $blogPostId;

    /**
     * @param BlogPostId $blogPostId
     */
    public function __construct(BlogPostId $blogPostId)
    {
        $this->blogPostId = $blogPostId;
    }

    /**
     * @return BlogPostId
     */
    public function blogPostId() : BlogPostId
    {
        return $this->blogPostId;
    }
}