<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                        I am another
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
          return {
            tc: {
              accessManager: null,
              messagingClient: null,
            }
          }
        },
        mounted() {
            console.log('Component mounted.');
            this.fetchAccessToken('Fred', 'ok');
        },
        methods: {
          fetchAccessToken(username, handler) {
            let vm = this;
            axios.post('http://localhost/twilio-chat/public//token', {
              identity: username,
              device: 'browser'
            })
            .then(function (response) {
              // console.log(response.data);
              vm.connectMessagingClient(response.data);
            })
            .catch(function (error) {
              console.log(error);
            });
          },
          connectMessagingClient(token) {
          // Initialize the Chat messaging client
          let vm = this;

          this.tc.accessManager = new Twilio.AccessManager(token);
          console.log(this.tc.accessManager);
          new Twilio.Chat.Client.create(token).then(function(client) {
            vm.tc.messagingClient = client;
            console.log(vm.tc.messagingClient);
            console.log("here");

            // updateConnectedUI();
            // tc.loadChannelList(tc.joinGeneralChannel);
            // tc.messagingClient.on('channelAdded', $.throttle(tc.loadChannelList));
            // tc.messagingClient.on('channelRemoved', $.throttle(tc.loadChannelList));
            // tc.messagingClient.on('tokenExpired', refreshToken);
          });
        }
        }


    }
</script>
