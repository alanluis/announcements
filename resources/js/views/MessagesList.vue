<template>
    <div>
        <div class="row">
            <div class="col-6"><h1>Messages</h1></div>
            <div class="col-6 text-right align-self-center">
                <router-link :to="{ name: 'messages.add' }" class="btn btn-primary"><i class="fa fa-plus"></i> Add</router-link>
            </div>
        </div>

        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">
                            <div class="d-none d-sm-block">Expiration Date</div>
                        </th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="message in messages" v-bind:key="message.id">
                        <th scope="row">{{ message.id }}</th>
                        <td>
                            <router-link :to="{ name: 'messages.view', query: {id: message.id } }">{{ message.subject }}
                            </router-link>
                        </td>
                        <td>{{ message.start_date }}</td>
                        <td>
                            <div class="d-none d-sm-block">{{ message.expiration_date }}</div>
                        </td>
                        <td>
                            <router-link :to="{ name: 'messages.edit', query: {id: message.id } }"
                                class="btn btn-warning">Edit</router-link>
                        </td>
                        <td><button @click="setDeleteMessage(message)" type="button" class="btn btn-danger"
                                data-toggle="modal" data-target="#exampleModal">
                                Delete
                            </button></td>
                    </tr>
                </tbody>
            </table>

            <div v-if="!loaded" class="d-flex justify-content-center">
                <div class="spinner-border flex-center" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div v-if="loaded && messages.length == 0" class="row text-center">
            <div class="col mb-12 mb-3">
                <i>There are no Messages</i>
            </div>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination mt-3">
                <li v-bind:class="[{disabled: pagination.current_page == 1}]" class="page-item d-none d-sm-block"><a class="page-link"
                        href="#" @click="fetchMessages()">First</a></li>

                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link"
                        href="#" @click="fetchMessages(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page
                        {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link"
                        href="#" @click="fetchMessages(pagination.next_page_url)">Next</a></li>

                <li v-bind:class="[{disabled: pagination.current_page == pagination.last_page}]" class="page-item d-none d-sm-block"><a class="page-link"
                        href="#" @click="fetchMessages(pagination.last_page_url)">Last</a></li>
            </ul>
        </nav>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you want to delete the message: {{this.message.subject}}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <a href="#delete"><button @click="deleteMessage(message.id)" type="button"
                                class="btn btn-danger" data-dismiss="modal">YES</button></a>
                    </div>
                </div>
            </div>
        </div>
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
                pagination: {},
                loaded: false
            };
        },

        created() {
            this.fetchMessages();
        },

        methods: {
            async fetchMessages(page_url) {
                try {
                    this.loaded = false;
                    page_url = page_url || process.env.MIX_ANNOUNCEMENTS_API_URL + '/messages';
                    const response = await fetch(page_url, {headers: new Headers({'Accept': 'application/json'})});
                    const responseJson = await response.json();
                    this.messages = responseJson.data;
                    this.makePagination(responseJson.meta, responseJson.links);
                } catch (error) {
                    console.log(error.message);
                }
                this.loaded = true;
            },
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    last_page_url: process.env.MIX_ANNOUNCEMENTS_API_URL + '/messages?page=' + meta.last_page,
                };

                this.pagination = pagination;
            },
            setDeleteMessage(message) {
                this.message = message;
            },
            async deleteMessage() {
                try {
                    const response = await fetch(`${process.env.MIX_ANNOUNCEMENTS_API_URL}/messages/${this.message.id}`, {method: 'delete'});
                    this.fetchMessages();
                } catch (error) {
                    console.log(error);
                }
            }
        },
        computed: {
            hasMessages() {
                return this.messages.length;
            }
        }
    };

</script>
