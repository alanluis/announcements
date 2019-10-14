<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top container">
            <router-link :to="{ name: 'messages.list' }" class="navbar-brand">Announcements</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link :to="{ name: 'messages.list' }" class="nav-link" data-toggle="collapse" data-target=".navbar-collapse.show">Messages</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'messages.add' }" class="nav-link" data-toggle="collapse" data-target=".navbar-collapse.show">Add Message</router-link>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="container">
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
    export default {}
</script>