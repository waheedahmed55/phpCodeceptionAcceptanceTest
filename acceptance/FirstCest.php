<?php
use Codeception\Util\Locator;

require_once 'pageObjects/objects.php';

class FirstCest
{
    public function searchModule(AcceptanceTester $I)
    {
            $pageObjects = new pageObjects();
            $random_day = $pageObjects->get_next_day();
            $I->maximizeWindow();
            $I->amOnUrl('http://www.tajawal.ae/');


            $random = rand(0,4);
            $random2 = rand(0,4);
            while($random2 == $random)
            {
              $random2 = rand(0,4);
            }

            $I->fillField($pageObjects->origin_field, $pageObjects->cities[$random]['destination']);
            $I->fillField($pageObjects->destination, $pageObjects->cities[$random2]['destination']);

            $I->click($pageObjects->date_picker);
            $I->click($pageObjects->next_month);
            $I->click($random_day);

            $I->wait(2);
            $travel_day = $I->grabTextFrom($pageObjects->aria);
            $return_day = $I->grabTextFrom(Locator::elementAt($pageObjects->ariaTwo, 2));

            $I->click($pageObjects->title_selector);
            $I->click($pageObjects->passengers_selector);
            $I->click($pageObjects->add_adult);
            $I->click($pageObjects->search_button);
            $I->wait(15);
            $this->listing_page($travel_day, $return_day, $random, $random2, $I);


    }

    private function listing_page($travel_day, $return_day, $random, $random2, $I)
    {

        $pageObjects = new pageObjects();
        $I->waitForElementVisible($pageObjects->flightR, 30);
        $I->wait(1);
        $I->click($pageObjects->flightR);
        $I->seeInField($pageObjects->s_origin, explode(',', $pageObjects->cities[$random]['destination'])[0]);
        $I->seeInField($pageObjects->s_destination, explode(',', $pageObjects->cities[$random2]['destination'])[0]);
        //Assert that Assert that above search params are correct on modify search component.
        $I->wait(2);
        \PHPUnit_Framework_Assert::assertEquals($I->grabValueFrom($pageObjects->t_day), $travel_day, 'Departure date must be equal');
        \PHPUnit_Framework_Assert::assertEquals($I->grabTextFrom(Locator::elementAt($pageObjects->r_day, 2)), $return_day, 'Return date must be equal');
        \PHPUnit_Framework_Assert::assertEquals($I->grabTextFrom(Locator::elementAt($pageObjects->travel_class, 1)), "Economy", 'Travel class must be equal');
        \PHPUnit_Framework_Assert::assertEquals($I->grabTextFrom(Locator::elementAt($pageObjects->passengers, 1)), "2 Passengers", 'Passengers must be equal');
        //Filter results
        $I->wait(2);
        $I->executeJS('$(".h_page__content").click()');
        $I->executeJS('$("#flights-filters-airline-leg-0-check_0").click()');
        $I->executeJS("try { $($('" . ".filters__checkbos-fix .filter-options:first-child .form-group .font-base:contains(\'EK: Emirates\')" . "').get(0).parentNode.nextElementSibling).click(); } catch (e) {}");
        $I->executeJS('$("#flights-filters-airline-leg-1-check-exclude-0").click()');
        $I->executeJS("try { $($('" . ".filters__checkbos-fix .filter-options:first-child .form-group .font-base:contains(\'XY: flynas\')" . "').get(0).parentNode.nextElementSibling).click(); } catch (e) {}");

        try {
            $I->seeElement('translate');
            $I->executeJS('$("#flights-filters-can-show-airline-cta-1").click()');
        } catch (Exception $e) {
        }
        $I->wait(3);
        $I->waitForElementVisible($pageObjects->f_results, 30);
        // get the price
        $price = $I->grabTextFrom(Locator::elementAt($pageObjects->first_price, 1));
        $price = str_replace(',', '', strval(preg_replace("/[^0-9,.]/", "", $price)));
        $I->executeJS('$("#flights-results-select-cta-btn-desktop-0").click()');
        //4- On travelers details page provide below requirements and proceed to second page:
        // assertions - get the total displayed in the cart
        $I->waitForElementVisible($pageObjects->price_container, 30);
        $I->wait(3);
        $cartTotalPassengerPage = $I->grabTextFrom($pageObjects->container_selector);
        $cartTotalPassengerPage = str_replace(',', '', (preg_replace("/[^0-9,.]/", "", $cartTotalPassengerPage)));
        //Fetch the cart price and make sure it is aligned with listing price.
        \PHPUnit_Framework_Assert::assertEquals($cartTotalPassengerPage, $price, 'prices must be equal');
        //Calculate fare break down for each traveler and compared it against cart total as it
        //should be equal.
        $I->executeJS("$('.panel-title.cursor-pointer.ab__textcase-normal.fare-summary__traveller-name')[0].click()");
        $I->executeJS("$('.panel-title.cursor-pointer.ab__textcase-normal.fare-summary__traveller-name')[1].click()");
        $individual_price = 0;
        //$individual_price += preg_replace("/[^0-9,.]/", "", $I->grabTextFrom("//*[contains(@class, 'tj-rate__price')][1]"));
        $individual_price += preg_replace("/[^0-9,.]/", "", $I->grabTextFrom(Locator::elementAt($pageObjects->passenger_fare, 1)));
        $individual_price += preg_replace("/[^0-9,.]/", "", $I->grabTextFrom(Locator::elementAt($pageObjects->passenger_fare, 2)));
        $individual_price += preg_replace("/[^0-9,.]/", "", $I->grabTextFrom(Locator::elementAt($pageObjects->passenger_fare, 3)));
        $individual_price += preg_replace("/[^0-9,.]/", "", $I->grabTextFrom(Locator::elementAt($pageObjects->passenger_fare, 4)));
        //Check if all the individual prices match the previous price
        \PHPUnit_Framework_Assert::assertEquals($individual_price, $price, 'prices must be equal');
        //Fill travelers details with proper entries

        $this->selectFromDropdown($pageObjects->title_1, 2, $I);
        $this->selectFromDropdown($pageObjects->title_0, 2, $I);
        $I->fillField($pageObjects->first_0, 'John');
        $I->fillField($pageObjects->middle_0, 'Paul');
        $I->fillField($pageObjects->last_0, 'Smith');
        $I->fillField($pageObjects->first_1, 'John');
        $I->fillField($pageObjects->middle_1, 'Paul');
        $I->fillField($pageObjects->last_1, 'Smith');
        //$I->waitForElementVisible('#flights-summary-travelers-form-birthDay-0', 30);
        $I->wait(2);

        try {
            $I->seeElement('#flights-summary-travelers-form-birthDay-0');

            for ($i = 0; $i < 2; $i++) {
                //$I->executeJS("$().click();");
                $this->selectFromDropdown('#flights-summary-travelers-form-birthDay-'.$i, 5, $I);
                $this->selectFromDropdown('#flights-summary-travelers-form-birthMonth-'.$i, 5, $I);
                $this->selectFromDropdown('#flights-summary-travelers-form-birthYear-'.$i, 25, $I);
                $this->selectFromDropdown('#flights-summary-travelers-form-countryId-'.$i, 3, $I);
                $this->selectFromDropdown('#flights-summary-travelers-form-passport-details-'.$i, 2, $I);
                $this->selectFromDropdown('#flights-summary-travelers-form-identityCountryId-'.$i, 3, $I);
                $I->fillField('#flights-summary-travelers-form-last-name-'.$i, 'Smith');
                $I->fillField('#flights-summary-travelers-form-idNumber-'.$i, '424242424242');
                $this->selectFromDropdown('#flights-summary-travelers-form-idExpiryDateDay-'.$i, 3, $I);
                $this->selectFromDropdown('#flights-summary-travelers-form-idExpiryDateMonth-'.$i, 3, $I);
                $this->selectFromDropdown('#flights-summary-travelers-form-idExpiryDateYear-'.$i, 5, $I);
            }

        } catch (Exception $e) {
        }


        // we loop twice - once for each passenger and we're giving them the same birthdate, etc


        $this->selectFromDropdown('#flights-summary-travelers-form-contact-title', 2, $I);
        $I->fillField('#flights-summary-travelers-form-contact-fname', 'John');
        $I->fillField('#flights-summary-travelers-form-contact-lname', 'Paul');
        $I->fillField('#flights-summary-travelers-form-contact-email', 'paul.smith@tajawal.ae');
        $I->fillField('#flights-summary-travelers-form-contact-phone', '45182000');
        // continue to the payment page
        $I->wait(2);
        $I->executeJS('$("#flights-summary-go-to-payment-cta").click()');
        $I->waitForElementVisible('#flights-payment-paynow', 30);
        //5 - On payment page:
        $I->waitForElementVisible('h2.pull-right', 30);
        $pagefivecart = $I->grabTextFrom("//h2[contains(@class, 'pull-right')]");
        $pagefivecart = str_replace(',', '', (preg_replace("/[^0-9,.]/", "", $cartTotalPassengerPage)));
        \PHPUnit_Framework_Assert::assertEquals($pagefivecart, $price, 'prices must be equal');
        $I->fillField('#common-credit-card-holder', 'John P Smith');
        // this is a fake number from Stripe
        $I->fillField('#common-credit-card-number', '4242424242424242');
        $this->selectFromDropdown('[name="expiry_month"]', 2, $I);
        $this->selectFromDropdown('[name="expiry_year"]', 2, $I);
        $I->fillField('#common-credit-card-cvv', '123');
        $I->executeJS('$("#flights-payment-paynow").click()');
        //Finally, assert for the payment error message
        $I->waitForElementVisible('.noty_text', 30);
        \PHPUnit_Framework_Assert::assertEquals($I->grabTextFrom(".noty_text"), "The transaction has been declined. The card details you have provided may be incorrect, please recheck the card information and try again. Should the error still occur, please contact your card issuer, or use a different card to complete your booking.", 'Error message should be equal');
        $I->makeScreenshot();
        $I->wait(15);

    }

    private function selectFromDropdown($selector, $n, $I)
    {
        $option = $I->grabTextFrom($selector . ' option:nth-child(' . $n . ')');
        $I->selectOption($selector, $option);
    }

    //  $I->click('.filters__checkbos-fix .filter-options:last-child .form-group .font-base:contains(\"XY: flynas\")');
}
