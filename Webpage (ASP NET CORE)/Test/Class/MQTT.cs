using System;
using System.Security.Cryptography.X509Certificates;
using System.Text;
using uPLibrary.Networking.M2Mqtt;

namespace Library.Class
{
    public class MQTT
    {
        private static MqttClient IotClient;

        public static void Init()
        {
            string IotEndPoint = "*************.amazonaws.com"; //AWS ENDPOINT
            X509Certificate CaCert = X509Certificate.CreateFromCertFile(@"***********\root-CA.crt"); //AWS ROOT CERT
            X509Certificate ClientCert = new X509Certificate2(@"*******************\dotnet_devicecertificate.pfx", "password"); //AWS IOT DEVICE CERT, REFER TO REFERENCE BELOW

            string ClientId = Guid.NewGuid().ToString();
            IotClient = new MqttClient(IotEndPoint, 8883, true, CaCert, ClientCert, MqttSslProtocols.TLSv1_2);
            IotClient.Connect(ClientId);
            while (!IotClient.IsConnected) { }
        }
        public static void Publish()
        {
            string Topic = "***************"; //TOPIC
            string Message = "****"; //MESSAGE
            IotClient.Publish(Topic, Encoding.UTF8.GetBytes(Message));
        }
    }
}

//Reference https://github.com/aws-samples/iot-dotnet-publisher-consumer