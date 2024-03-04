<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;    
    protected $type;
    protected $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order,$type)
    {
       
         $this->order = $order;
         $this->type = $type;
        // $this->contactNumber = $contactNumber;
        // $this->message = $message;
         $this->title        = 'Booking Request from Holidays Bookers';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {      
        
 
        $tableView = orderTableHTML($this->order); 
    
  
        if( $this->type == "admin" ){                                
             $this
            ->to(env('ADMIN_EMAIL'))
            ->subject($this->title)
            ->view('emails.order-admin', [
                'order'     => $this->order,           
                'tableView'     => $tableView,  
                'templateName'     => 'Order', 
                'receive'     => 'admin',         
            ]);
            
        } else if( $this->type == "agent" ){                          
             $this
            ->to($this->order->agent_email) 
            ->subject($this->title)
            ->view('emails.order-agent', [
                'order'     => $this->order,           
                'tableView'     => $tableView,  
                'templateName'     => 'Order',  
                'receive'     => 'agent',       
            ]);
        } else if( $this->type == "hotel" ){   
           
            $hotelEmaills = [];            
            $hotelId = [];
            if (count($this->order->order_hotel) > 0) { 
                foreach ($this->order->order_hotel as $key => $value) {                    
                    $email = [];                    
                    $email = array(
                        'hotel_email' => $value->hotel->hotel_email                        
                    );
                    $hotelId[$value->hotel->id] = $email;
                } 
            }
            if(is_array($hotelId) && count($hotelId) > 0){
                foreach ($hotelId as $key => $value) {
                    $hotelEmaills[] = $value['hotel_email'];
                }                
            }
            
            $this
           ->to($hotelEmaills)
           ->subject($this->title)
           ->view('emails.order-hotel', [
               'order'     => $this->order,           
               'tableView'     => $tableView,  
               'hotelidArr'     => $hotelId,  
               'templateName'     => 'Order',  
               'receive'     => 'hotel',       
           ]);
          
       } else if( $this->type == "account" ){     
        
        $sales_email = [];            
            $hotelId = [];
            if (count($this->order->order_hotel) > 0) { 
                foreach ($this->order->order_hotel as $key => $value) {   
                              
                    $email = [];                    
                    $email = array(
                        'sales_email' => $value->hotel->sales_email                        
                    );
                    $hotelId[$value->hotel->id] = $email;
                } 
            }
            if(is_array($hotelId) && count($hotelId) > 0){
                foreach ($hotelId as $key => $value) {
                    $sales_email[] = $value['sales_email'];
                }                
            }


            $this
            ->to($sales_email)
            ->subject($this->title)
            ->view('emails.order-account', [
                'order'     => $this->order,           
                'tableView'     => $tableView,  
                'templateName'     => 'Order',  
                'receive'     => 'agent',       
            ]);
        } else if( $this->type == "sales" ){ 
            
            $sales_email = [];            
            $hotelId = [];
            if (count($this->order->order_hotel) > 0) { 
                foreach ($this->order->order_hotel as $key => $value) {   
                                
                    $email = [];                    
                    $email = array(
                        'sales_email' => $value->hotel->sales_email                        
                    );
                    $hotelId[$value->hotel->id] = $email;
                } 
            }
            if(is_array($hotelId) && count($hotelId) > 0){
                foreach ($hotelId as $key => $value) {
                    $sales_email[] = $value['sales_email'];
                }                
            }

            $this
            ->to($sales_email)
            ->subject($this->title)
            ->view('emails.order-sales', [
                'order'     => $this->order,           
                'tableView'     => $tableView,  
                'templateName'     => 'Order',  
                'receive'     => 'agent',       
            ]);
        } else if( $this->type == "front_office" ){   
            
            $front_office_email = [];            
            $hotelId = [];
            if (count($this->order->order_hotel) > 0) { 
                foreach ($this->order->order_hotel as $key => $value) {   
                                
                    $email = [];                    
                    $email = array(
                        'front_office_email' => $value->hotel->front_office_email                        
                    );
                    $hotelId[$value->hotel->id] = $email;
                } 
            }
            if(is_array($hotelId) && count($hotelId) > 0){
                foreach ($hotelId as $key => $value) {
                    $front_office_email[] = $value['front_office_email'];
                }                
            }

            $this
            ->to($front_office_email)
            ->subject($this->title)
            ->view('emails.order-front-office', [
                'order'     => $this->order,           
                'tableView'     => $tableView,  
                'templateName'     => 'Order',  
                'receive'     => 'agent',       
            ]);
        } else if( $this->type == "reservation" ){  
            
            $reservation_email = [];            
            $hotelId = [];
            if (count($this->order->order_hotel) > 0) { 
                foreach ($this->order->order_hotel as $key => $value) {   
                                
                    $email = [];                    
                    $email = array(
                        'reservation_email' => $value->hotel->reservation_email                        
                    );
                    $hotelId[$value->hotel->id] = $email;
                } 
            }
            if(is_array($hotelId) && count($hotelId) > 0){
                foreach ($hotelId as $key => $value) {
                    $reservation_email[] = $value['reservation_email'];
                }                
            }

            $this
            ->to($reservation_email)
            ->subject($this->title)
            ->view('emails.order-reservation', [
                'order'     => $this->order,           
                'tableView'     => $tableView,  
                'templateName'     => 'Order',  
                'receive'     => 'agent',       
            ]);
        } 
        
        
    }
}
