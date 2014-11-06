Feature: content metadata
    In order to simplify blog post creation
    As a blog author
    I need to be able to add metadata within the content file

    Scenario:
        Given I have a "post" file named "hello-world.md"
        And I provided "title" metadata as "Hello World"
        And I provided "date" metadata as "2015-05-16"
        When I am on "/hello-world"
        Then I should see "Hello World"
        And I should see "Published: May 16 2015"