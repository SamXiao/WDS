<?php
require_once 'BaseTestCase.php';

class EventTest extends BaseTestCase
{


//     public function testCreateEvent()
//     {

//         $this->url('/create/event/');
//         $eventTitle = $this->byName('title')->value('AutoTest New Event');
//         $this->select($this->byName('organizationRole'))->selectOptionByValue('ORGNZ');
//         $this->select($this->byName('eventType'))->selectOptionByValue('LIFEST');
//         $this->select($this->byName('defaultLanguage'))->selectOptionByValue('en');

//         $this->byCssSelector('button[type="submit"]')->click();
//         $this->assertContains('invalid', $this->byCssSelector('.industryHolder')->attribute('class'));

//         $this->select($this->byName('industry'))->selectOptionByValue('ELEC');
//         $this->byCssSelector('button[type="submit"]')->click();
//         $this->waitUntil(function($case){
//         	if ( strpos($case->url(), 'teamMembers') ){
//         	    return true;
//         	}
//         },10000);
//         $this->assertContains('<span class="progress-step-num">2</span>', $this->source());

//         $this->byCssSelector('.btn-success')->click();
//         $this->assertContains('<span class="progress-step-num">3</span>', $this->source());

//         $this->byCssSelector('.btn-default')->click();
//         $this->assertContains('AutoTest New Event', $this->source());

//     }


// 	public function testEventTeam()
// 	{
// 	    $this->url('/events/334/members');
// 	    $orgMemberItem = $this->byCssSelector('.create-event-member-list li[data-user-id="9"]');

// 	    $orgMemberItem->byCssSelector('.input')->click();
// 	    $this->timeouts()->asyncScript(10000);

// 	    $teamMemberItem = $this->byCssSelector('.create-event-team-list li[data-user-id="9"]');
// 	    $this->assertEquals('Sam Xiao', $teamMemberItem->text());
// 	    $this->assertContains('is-member', $orgMemberItem->attribute('class'));

// 	    $teamMemberItem->byCssSelector('.icon-remove')->click();
// 	    $this->clickOnElement('btn-remove-member');
// 	    $this->timeouts()->asyncScript(10000);
// 	    $this->assertNotContains('is-member', $orgMemberItem->attribute('class'));


// 	}



	public function testAddAttendee()
	{
	    $this->url('/events/334/attendees/registrations/');
	    $this->byCssSelector('.addattendee-button')->click();
	    $this->byClassName('showDetailsButton')->click();
        $this->byName('firstName')->value('Auto');
        $this->byName('lastName')->value('TestAdd');
        $this->byName('phone')->value('12312341234');
        $this->byName('email')->value('testadd@auto.com');
        $this->select($this->byName('category'))->selectOptionByValue('3');
        $this->select($this->byName('writtenPaidStatus'))->selectOptionByValue('Paid');
        $this->byCssSelector('form button[type="submit"]')->click();
	    $this->url('/events/334/attendees/registrations/category/3/status/all');
	    $this->assertContains('TestAdd', $this->source());
	    $this->assertContains('Auto', $this->source());
	    $this->assertContains('testadd@auto.com', $this->source());
	}



}
