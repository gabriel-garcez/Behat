Feature: Library Books
Scenario: I want add a book to the library
Given I am an authorized user
When I request to add a book for 'http://216.10.245.166'
Then The book is added successfully