<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Message;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     @test
     */
    public function a_message_can_be_added()
    {
        $response = $this->post('api/messages', $this->getMessageSampleData());
        
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertCount(1, Message::all());
    }

    /**
     @test
     */
    public function a_subject_is_required()
    {
        $message = $this->getMessageSampleData();
        $message['subject'] = '';
        $response = $this->post('api/messages', $message );
        
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertSessionHasErrors('subject');
        $this->assertCount(0, Message::all());
    }

    /**
     @test
     */
    public function a_message_can_be_updated()
    {
        $response = $this->post('api/messages', $this->getMessageSampleData());

        $messageId = Message::first()->id;
        
        $updatedMessage = [
            'subject' => 'Subject Updated',
            'content' => 'Content Updated',
            'start_date' => '2019-10-02',
            'expiration_date' => '2019-10-11'
        ];

        $response = $this->put('api/messages/' . $messageId, $updatedMessage);
        
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals('Subject Updated', Message::first()->subject);
        $this->assertEquals('Content Updated', Message::first()->content);

        $this->assertCount(1, Message::all());
    }

    /**
     @test
     */
    public function a_message_can_be_deleted()
    {
        $response = $this->post('api/messages', $this->getMessageSampleData());

        $messageId = Message::first()->id;

        $response = $this->delete('api/messages/' . $messageId);
        
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertCount(0, Message::all());
    }

    private function getMessageSampleData() {
        return [
            'subject' => 'Subject',
            'content' => 'Content',
            'start_date' => '2019-10-01',
            'expiration_date' => '2019-10-10'
        ];
    }
}
