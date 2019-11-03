<template>
    <div>
        <h1>Edit Message</h1>

        <div v-if="validationErrors">
            <ul class="alert alert-danger">
                <li v-for="(value, key) in validationErrors" v-bind:key="key">{{ value }}</li>
            </ul>
        </div>

        <form  v-if="message" @submit.prevent="saveMessage">
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" id="subject" v-model="message.subject" placeholder="Enter subject">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" rows="3" v-model="message.content"></textarea>
        </div>
        <div class="form-group">
            <label for="start_date">Start date</label>
            <input type="date" class="form-control" id="start_date" v-model="message.start_date">
        </div>
        <div class="form-group">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" class="form-control" id="expiration_date" v-model="message.expiration_date">
        </div>
        <button type="submit" class="btn btn-primary mr-3"><i class="fa fa-paper-plane" aria-hidden="true"></i> Submit</button>
        <router-link :to="{ name: 'messages.list' }" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Messages</router-link>
        </form>

        <div v-if="!message" class="d-flex justify-content-center">
            <div class="spinner-border flex-center" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
  created() {
    this.fetchMessage();
  },
  data() {
    return {
      message: false,
      errors : ''
    };
  },

  methods: {
    fetchMessage() {
      let vm = this;
      fetch('/api/messages/' + this.$route.query.id)
        .then(res => res.json())
        .then(res => {
          this.message = res.data;
        })
        .catch(err => console.log(err));
    },
    saveMessage() {
      let self = this;
      axios.put('/api/messages/' + this.$route.query.id, this.message)
      .then(function(response) {
        self.$router.push({ name: "messages.list" });
      })
      .catch(error => {
        if (error.response.status == 422){
            this.errors = error.response.data.errors;
        }
      });
    }
  },
  computed: {
      validationErrors(){
          if (this.errors == '') {return false};
          let errors = Object.values(this.errors);
          errors = errors.flat();
          return errors;
      }
  }
}
</script>