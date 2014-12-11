Feature: view category or tag archive
    In order to simplify blog post creation
    As a blog author
    I need to be able to add category/tag metadata to posts
    and have posts in that category/tag rendered as an archive
    when a particular URI is hit.

    Scenario:
        Given I have a "post" file named "hello-world.md"
        And I provided "categories" metadata including "Web Development"
        When I am on "/category/web-development"
        Then I should see "Hello World"

    Scenario:
        Given I have a "post" file named "hello-world.md"
        And I provided "tag" metadata including "tag1"
        When I am on "/tag/tag1"
        Then I should see "Hello World"