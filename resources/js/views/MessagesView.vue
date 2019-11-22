<template>
    <div>
        <h1>View Message</h1>
        <div v-if="message" class="content">
          <div class="row">
              <div class="col-4"><strong>Subject</strong></div>
              <div class="col-8">{{ message.subject }}</div>
          </div>
          <div class="row">
              <div class="col-4"><strong>Content</strong></div>
              <div class="col-8">{{ message.content }}</div>
          </div>
          <div class="row">
              <div class="col-4"><strong>Start Date</strong></div>
              <div class="col-8">{{ message.start_date }}</div>
          </div>
          <div class="row mb-3">
              <div class="col-4"><strong>Expiration Date</strong></div>
              <div class="col-8">{{ message.expiration_date }}</div>
          </div>

          <div class="row mb-3">
              <div class="col d-flex flex-nowrap">
              <router-link :to="{ name: 'messages.list' }" class="btn btn-secondary mr-3"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Messages</router-link>
              <router-link :to="{ name: 'messages.edit', query: {id: message.id } }" class="btn btn-warning"><i class="fa fa-edit" aria-hidden="true"></i> Edit Message</router-link>
              </div>
          </div>

          <div class="row">
              <div class="col-12"><i>Created at {{ message.created_at }}</i></div>
          </div>
          <div v-if="message.updated_at" class="row">
              <div class="col-12"><i>Updated at {{ message.updated_at }}</i></div>
          </div>
        </div>

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
    };
  },

  methods: {
    fetchMessage() {
      let vm = this;
      fetch(process.env.MIX_ANNOUNCEMENTS_API_URL + '/messages/' + this.$route.query.id)
        .then(res => res.json())
        .then(res => {
          this.message = res.data;
        })
        .catch(err => console.log(err));
    },
  }
}
</script>