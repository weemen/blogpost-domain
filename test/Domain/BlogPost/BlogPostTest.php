<?php

namespace Weemen\BlogPost\Domain\BlogPost;


use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

class BlogPostTest extends AggregateRootScenarioTestCase
{

    public function testItCanCreateNewBlogPost()
    {
        $blogPostId = new BlogPostId($this->createGenerator()->generate());

        $this->scenario
            ->when(function() use ($blogPostId) {
                return BlogPost::createBlogPost($blogPostId, "title", "content", "Leon", false, "twitter");
            })
            ->then([new BlogPostCreated($blogPostId, "title", "content", "Leon", false, "twitter")]);
    }

    public function testItCanEditExistingBlogPost()
    {
        $blogPostId = new BlogPostId($this->createGenerator()->generate());
        $title      = "blogPostTitle";
        $content    = "content";
        $author     = "Leon";
        $published  = false;
        $source     = "twitter";

        $this->scenario
            ->withAggregateId($blogPostId)
            ->given([
                new BlogPostCreated($blogPostId, "originalTitle", "originalContent", "originalAuthor", $published, "twitter")
            ])
            ->when(function($blogPost) use ($blogPostId, $title, $content, $author, $published, $source) {
                $blogPost->editBlogPost($blogPostId, $title, $content, $author, $published, $source);
            })
            ->then([
                new BlogPostEdited($blogPostId, $title, $content, $author, $published, $source)
            ]);
    }

    /**
     * @expectedException \Weemen\BlogPost\Domain\Exception\DomainException
     * @expectedExceptionMessage Blog post title cannot be empty
     */
    public function testTitleCannotBeEmpty()
    {
        $blogPostId = new BlogPostId($this->createGenerator()->generate());
        $title      = "";
        $content    = "content";
        $author     = "Leon";
        $published  = false;
        $source     = "twitter";

        $this->scenario
            ->withAggregateId($blogPostId)
            ->given([
                new BlogPostCreated($blogPostId, "originalTitle", "originalContent", "originalAuthor", $published, "twitter")
            ])
            ->when(function($blogPost) use ($blogPostId, $title, $content, $author, $published, $source) {
                $blogPost->editBlogPost($blogPostId, $title, $content, $author, $published, $source);
            })
            ->then([
                new BlogPostEdited($blogPostId, $title, $content, $author, $published, $source)
            ]);
    }

    /**
     * @expectedException \Weemen\BlogPost\Domain\Exception\DomainException
     * @expectedExceptionMessage Blog post content cannot be empty
     */
    public function testContentCannotBeEmpty()
    {
        $blogPostId = new BlogPostId($this->createGenerator()->generate());
        $title      = "title";
        $content    = "";
        $author     = "Leon";
        $published  = false;
        $source     = "twitter";

        $this->scenario
            ->withAggregateId($blogPostId)
            ->given([
                new BlogPostCreated($blogPostId, "originalTitle", "originalContent", "originalAuthor", $published, "twitter")
            ])
            ->when(function($blogPost) use ($blogPostId, $title, $content, $author, $published, $source) {
                $blogPost->editBlogPost($blogPostId, $title, $content, $author, $published, $source);
            })
            ->then([
                new BlogPostEdited($blogPostId, $title, $content, $author, $published, $source)
            ]);
    }

    /**
     * @expectedException \Weemen\BlogPost\Domain\Exception\DomainException
     * @expectedExceptionMessage Blog post author cannot be empty
     */
    public function testAuthorCannotBeEmpty()
    {
        $blogPostId = new BlogPostId($this->createGenerator()->generate());
        $title      = "title";
        $content    = "content";
        $author     = "";
        $published  = false;
        $source     = "twitter";

        $this->scenario
            ->withAggregateId($blogPostId)
            ->given([
                new BlogPostCreated($blogPostId, "originalTitle", "originalContent", "originalAuthor", $published, "twitter")
            ])
            ->when(function($blogPost) use ($blogPostId, $title, $content, $author, $published, $source) {
                $blogPost->editBlogPost($blogPostId, $title, $content, $author, $published, $source);
            })
            ->then([
                new BlogPostEdited($blogPostId, $title, $content, $author, $published, $source)
            ]);
    }

    public function testBlogPostCanBeDeleted()
    {
        $blogPostId = new BlogPostId($this->createGenerator()->generate());

        $this->scenario
            ->withAggregateId($blogPostId)
            ->given([
                new BlogPostCreated($blogPostId, "originalTitle", "originalContent", "originalAuthor", false, "twitter")
            ])
            ->when(function($blogPost) use ($blogPostId) {
                $blogPost->deleteBlogPost($blogPostId);
            })
            ->then([
                new BlogPostDeleted($blogPostId)
            ]);
    }


    /**
     * Returns a string representing the aggregate root
     *
     * @return string AggregateRoot
     */
    protected function getAggregateRootClass()
    {
        return BlogPost::class;
    }

    /**
     * @return Version4Generator
     */
    protected function createGenerator() : Version4Generator
    {
        return new Version4Generator();
    }
}