<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /** @var \Zend\Mvc\Application */
    private static $zendApp;
    
    /** @BeforeSuite */
    static public function initializeZendFramework()
    {
        date_default_timezone_set('Europe/London');
        
        if (self::$zendApp === null) {
            $path = __DIR__ . '/../../config/application.config.php';
            
            self::$zendApp = Zend\Mvc\Application::init(
                require $path
            );
        }
    }
    
    /** @BeforeScenario */
    public function initDatabase()
    {
        $serviceManager = $this->getServiceManager();
    
        $userService = $serviceManager->get('Netsensia\Service\UserService');
        $testUserId = $userService->getUserIdFromEmail('test@netsensia.com');
    
        if ($testUserId) {
            $testUserModel = $serviceManager->get('UserModel')->init($testUserId);
            $testUserModel->set('password', '$2y$14$cBKJD3NnF6L4FuuEN7P1fOOepHEX5iN1XCA9U3.4SAIYGAUq5a6Iy');
            $testUserModel->save();
        } else {
            $testUserModel = $serviceManager->get('UserModel')->init();
            $testUserModel->setData(
                [
                    'email'=>'test@netsensia.com',
                    'password'=>'$2y$14$cBKJD3NnF6L4FuuEN7P1fOOepHEX5iN1XCA9U3.4SAIYGAUq5a6Iy',
                ]
            );
            $newUserId = $testUserModel->create();
        }
    }
    
    /** @return \Zend\ServiceManager\ServiceManager */
    private function getServiceManager()
    {
        return self::$zendApp->getServiceManager();
    }
    
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @Given /^I am in a directory "([^"]*)"$/
     */
    public function iAmInADirectory($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        chdir($dir);
    }
    
    /** @Given /^I have a file named "([^"]*)"$/ */
    public function iHaveAFileNamed($file)
    {
        touch($file);
    }
    
    /** @When /^I run "([^"]*)"$/ */
    public function iRun($command)
    {
        exec($command, $output);
        $this->output = trim(implode("\n", $output));
    }
    
    /** @Then /^I should get:$/ */
    public function iShouldGet(PyStringNode $string)
    {
        if ((string) $string !== $this->output) {
            throw new Exception(
                "Actual output is:\n" . $this->output
            );
        }
    }

    /**
     * @Given /^I am on the help page$/
     */
    public function iAmOnTheHelpPage()
    {
        $this->getSession()->visit($this->locatePath('/help'));
    }
    
    /**
     * @Given /^I am on the registration page$/
     */
    public function iAmOnTheRegistrationPage()
    {
        $this->getSession()->visit($this->locatePath('/register'));
    }  
}
