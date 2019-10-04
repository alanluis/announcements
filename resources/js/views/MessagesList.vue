<template>
    <div>
      <h1>Messages</h1>
      <div class="table-responsive-sm">
      <table class="table">
          <thead>
              <tr>
              <th scope="col">#</th>
              <th scope="col">Subject</th>
              <th scope="col">Start Date</th>
              <th scope="col"><div class="d-none d-sm-block">Expiration Date</div></th>
              <th scope="col">Edit</th>
              <th scope="col">Delete</th>
              </tr>
          </thead>
          <tbody>
              <tr v-for="message in messages" v-bind:key="messages.id">
              <th scope="row">{{ message.id }}</th>
              <td><router-link :to="{ name: 'messages.view', query: {id: message.id } }">{{ message.subject }}</router-link></td>
              <td>{{ message.start_date }}</td>
              <td><div class="d-none d-sm-block">{{ message.expiration_date }}</div></td>
              <td><router-link :to="{ name: 'messages.edit', query: {id: message.id } }" class="btn btn-warning">Edit</router-link></td>
              <td><button @click="deleteMessage(message.id)" class="btn btn-danger">Delete</button></td>              
              </tr>
        </tbody>
      </table>
      </div>

      <div v-if="!hasMessages" class="row">
        <div class="col mb-12 mb-3">
          There are no Messages <router-link :to="{ name: 'messages.add' }" class="btn btn-secondary">Add a new Message</router-link>
        </div>
      </div>

      <nav aria-label="Page navigation">
      <ul class="pagination mt-3">
          <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchMessages(pagination.prev_page_url)">Previous</a></li>

          <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
      
          <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchMessages(pagination.next_page_url)">Next</a></li>
      </ul>
      </nav>
    </div>
</template>

<script>
export default {
  data() {
    return {
      messages: [],
      message: {
        'id': '',
        'subject': '',
        'start_date': '',
        'expiration_date': ''
      },
      pagination: {}
    };
  },

  created() {
    this.fetchMessages();
  },

  methods: {
    fetchMessages(page_url) {
      let vm = this;
      page_url = page_url || '/api/messages';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.messages = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };

      this.pagination = pagination;
    },
    deleteMessage(id) {
      if (confirm('Are you sure?')) {
        let self = this;
        fetch(`api/messages/${id}`, {
          method: 'delete'
        })
          .then(function(response){
        self.fetchMessages();
      })
          
          .catch(err => console.log(err));
      }
    }
  },
  computed: {
      hasMessages(){
          return this.messages.length;
      }
  }
};
</script>