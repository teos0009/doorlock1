
#include <AWS_IOT.h>
#include <WiFi.h>
#include <Servo.h>

AWS_IOT hornbill;

char WIFI_SSID[]="WIFI SSID";
char WIFI_PASSWORD[]="WIFI PASSWORD";
char HOST_ADDRESS[]="AWS ENDPOINT";
char CLIENT_ID[]= "CLIENT ID";
char TOPIC_NAME[]= "AWS TOPIC";

Servo myservo;
int pos = 0; //servo pos

int status = WL_IDLE_STATUS;
int tick=0,msgCount=0,msgReceived = 0;
char payload[512]; // sending payload 
char rcvdPayload[512]; // receiving payload


void mySubCallBackHandler (char *topicName, int payloadLen, char *payLoad)
{
    strncpy(rcvdPayload,payLoad,payloadLen);
    rcvdPayload[payloadLen] = 0;
    msgReceived = 1;
}


void setup() {
    Serial.begin(115200);
    btStop(); // disable bluetooth to free heap memory

    myservo.attach(13); // servo to pin 13

    delay(2000);  

    Serial.print("Free Heap Memory in bytes: ");
    Serial.println(ESP.getFreeHeap()); // get free heap memory

    while (status != WL_CONNECTED)
    {
        Serial.print("Attempting to connect to SSID: ");
        Serial.println(WIFI_SSID);
        // Connect to WPA/WPA2 network. Change this line if using open or WEP network:
        status = WiFi.begin(WIFI_SSID, WIFI_PASSWORD);

        // wait 5 seconds for connection:
        delay(5000);
    }

    Serial.println("Connected to wifi");

    if(hornbill.connect(HOST_ADDRESS,CLIENT_ID)== 0) // connect to iot
    {
        Serial.println("Connected to AWS");
        delay(1000);

        if(hornbill.subscribe(TOPIC_NAME,mySubCallBackHandler) == 0) // subscribe
        {
            Serial.println("Subscribe Successfull");
        }
        else
        {
            Serial.println("Subscribe Failed, Check the Thing Name and Certificates");
            while(1);
        }
    }
    else
    {
        Serial.println("AWS connection failed, Check the HOST Address");
        while(1);
    }

    delay(2000);

}

void loop() {
    myservo.write(10);
    if(msgReceived == 1)
    {
        msgReceived = 0;
        Serial.print("Received Message:");
        Serial.println(rcvdPayload);
        if( (rcvdPayload[0] == 'a') && (rcvdPayload[1] == 'b') && (rcvdPayload[2] == 'c') && (rcvdPayload[3] == NULL) ) // checks receiving payload
        {
          Serial.print("SERVO OPEN\n");
          //for (pos = 0; pos <= 1; pos++) { // goes from 0 degrees to 180 degreesM
           // in steps of 1 degree
            //myservo.write(pos);              // tell servo to go to position in variable 'pos'
            //delay(1);                       // waits 15ms for the servo to reach the position
           //}
           //for (pos = 1; pos >= 0; pos--) { // goes from 180 degrees to 0 degrees
             //myservo.write(pos);              // tell servo to go to position in variable 'pos'
             //delay(1);                       // waits 15ms for the servo to reach the position
           //}
           delay(100);
           myservo.write(170);
           delay(100);
           
        }
        else
        {
          Serial.print("WRONG PAYLOAD\n");
        }
    }
    if(tick >= 10)   // publish to topic every 10 seconds
    {
        tick=0;
        sprintf(payload,"Hello from ESP32 : %d",msgCount++);
        if(hornbill.publish(TOPIC_NAME,payload) == 0) // publish message
        {        
            Serial.print("Publish Message:");
            Serial.println(payload);
        }
        else
        {
            Serial.println("Publish failed");
        }
    }  
    vTaskDelay(1000 / portTICK_RATE_MS); 
    tick++;
}
