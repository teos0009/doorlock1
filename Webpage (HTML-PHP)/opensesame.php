<!DOCTYPE html>
<html>
<head>
 <script type="text/javascript" src="./bower_components/moment/min/moment.min.js"></script>
<script type="text/javascript" src="./bower_components/angular/angular.min.js"></script>
<script type="text/javascript" src="./bower_components/paho-mqtt-js/mqttws31.js"></script>
<script type="text/javascript" src="./bower_components/cryptojslib/rollups/sha256.js"></script>
<script type="text/javascript" src="./bower_components/cryptojslib/rollups/hmac-sha256.js"></script>
<script type="text/javascript" src="./js/app.js"></script>
<link type="text/css" rel="stylesheet" href="./bower_components/bootstrap/dist/css/bootstrap.min.css"/>
</head>
<body>
<div class="container" ng-app="awsiot.sample" ng-controller="AppController as vm">
<br>
<br>
    <div class="row">
      <div class="form-group">
        <center><button id="hide" class="btn btn-primary" ng-click="vm.createClient()">Unlock Door</button></center>
      </div>
    </div>
    <div class="panel panel-info" ng-repeat="clientCtr in vm.clients.val">
      <div class="panel-heading">
        <button type="button" class="close"  ng-click="vm.removeClient(clientCtr)"><span>&times;</span></button>
        <h3 class="panel-title"></h3>
      </div>
      <div class="panel-body row">
        <div class="col-md-6">
          <p></p>
          <div class="form-inline">
            <div class="form-group">
              <label for="topicInput"></label>
              <input type="hidden" class="form-control" id="topicInput" placeholder="Topic" ng-model="clientCtr.topicName" readonly/>
            </div>
            <button class="btn btn-primary" ng-click="clientCtr.subscribe(); clientCtr.msgInputKeyUp()">Subscribe</button>
          </div>
          <div>
            <p></p>
			<button class="btn btn-primary" ng-model="clientCtr.message" ng-click="clientCtr.msgInputKeyUp()">Send message</button>

          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-info" ng-repeat="msg in clientCtr.msgs">
            <div class="panel-heading">
              <h3 class="panel-title">{{msg.destination}} -> {{msg.receivedTime | date: 'medium'}}</h3>
            </div>
            <div class="panel-body"> {{msg.content}} </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <h3>Logs:</h3>
      <ul class="list-group">
        <li ng-repeat="log in vm.logs.logs | orderBy:'createdTime':true" class="list-group-item" ng-class="log.className">
          {{log.createdTime | date: 'medium'}} - {{log.content}}
        </li>
      </ul>
    </div>
  </div>
  </body>
  </html>