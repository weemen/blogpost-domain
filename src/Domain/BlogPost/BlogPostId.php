<?php

namespace Weemen\BlogPost\Domain\BlogPost;


class BlogPostId
{

    /**
     * @var string|string
     */
    public $blogPostId;

    /**
     * @param string $blogPostId
     */
    public function __construct(string $blogPostId)
    {
        $this->blogPostId = $blogPostId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->blogPostId;
    }
}