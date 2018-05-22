<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link tag="a" class="nav-link" to="/">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" class="nav-link" to="/categories">Categories</router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" class="nav-link" to="/login">Login</router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" class="nav-link" to="/register">Register</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>