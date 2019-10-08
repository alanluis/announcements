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
        $response = $this->json('POST', 'api/messages', $this->getMessageSampleData());
        
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertCount(1, Message::all());
    }

    /**
     @test
     */
    public function messages_api_should_retrieve_json_format()
    {
        $response1 = $this->post('api/messages', array_merge($this->getMessageSampleData(), ['subject'=>'content1']));
        $response2 = $this->post('api/messages', array_merge($this->getMessageSampleData(), ['subject'=>'content2']));
        
        $this->assertEquals(201, $response1->getStatusCode());
        $this->assertEquals(201, $response2->getStatusCode());

        $this->assertCount(2, Message::all());

        $response = $this->get('api/messages')
            ->assertJsonCount(2, 'data')
            ->assertSee('"subject":"content1"')
            ->assertSee('"subject":"content2"');
    }

    /**
     @test
     */
    public function a_subject_is_required()
    {
        $message = $this->getMessageSampleData();
        $message['subject'] = '';
        $response = $this->json('POST', 'api/messages', $message);
    
        $this->assertEquals(422, $response->getStatusCode());
        $response->assertJsonFragment(['message'=> 'The given data was invalid.']);
        $response->assertJsonFragment(['subject'=> ['The subject field is required.']]);
    
        $this->assertCount(0, Message::all());
    }

    /**
     @test
     */
    public function a_message_can_be_updated()
    {
        $response = $this->json('POST', 'api/messages', $this->getMessageSampleData());

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

    private function getMessageSampleData()
    {
        return [
            'subject' => 'Subject',
            'content' => 'Content',
            'start_date' => '2019-10-01',
            'expiration_date' => '2019-10-10'
        ];
    }
}
