@extends('layouts.base')

@section('title','TOP page')

@section('container')
    <div class="container">
        <div id="app-4">
            <button v-on:click="addTodos">add</button>
            <input v-model="message">
            <ol>
                <todo-item v-for="(item, index) in groceryList" v-bind:todo="item" v-if="item.seen"></todo-item>
            </ol>
        </div>
    </div>
    <script>
        Vue.component('todo-item', {
            props: ['todo'],
            template: '<li>@{{ index }} -- @{{ todo.id }} -- @{{ todo.text }}</li>'
        })
        
        var app = new Vue({
            el: '#app-4',
            data: {
                groceryList: [
                    { id: 01, text: 'Learn JavaScript', seen: true },
                    { id: 10, text: 'Learn Vue', seen: false },
                    { id: 20, text: 'Build something awesome', seen: true }
                ],
                message: ''
            },
            methods: {
                addTodos: function() {
                    this.groceryList.push({text: this.message})
                }
            }
        })
    </script>
@endsection