<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Psr7\Request;


/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    protected $response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I am an authorized user
     */
    public function iAmAnAuthorizedUser()
    {
        
       $client = new GuzzleHttp\Client(['base_uri' => 'http://216.10.245.166']);

       $response = $client->get('/Library/Addbook.php');
       
       $responseCode = $response->getStatusCode();
       
       if ($responseCode != 200) {
           throw new Exception("Expected 200 but recieved ", $responseCode);
        }

        return true;
        
    }


    /**
     * @When I request to add a book for :arg1
     */
    public function iRequestToAddABookFor($arg1)
    {

        $client = new GuzzleHttp\Client(['base_uri' => $arg1]);

        $this->response = $client->request('POST', '/Library/Addbook.php', [
         'body' => '{
             "name":"How to do tests with Behat",
             "isbn":"A8H6",
             "aisle":"P98J",
             "author":"Gabriel Rockstar Coders"
         }'
     ]);
        
        $responseCode = $this->response->getStatusCode();
        
        if ($responseCode != 200) {
            throw new Exception("Expected 200 but recieved ", $responseCode);
         }
 
         return true;
         
     }
       

    /**
     * @Then The book is added successfully
     */
    public function theBookIsAddedSuccessfully()
    {

        $books = json_decode($this->response->getBody(), true);

        if($books['ID'] == 'A8H6P98J') {
            return true;
        }

        throw new Exception("Expected to find book 123 but didn't."); 


    }


    }