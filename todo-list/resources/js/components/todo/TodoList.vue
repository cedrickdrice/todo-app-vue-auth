<template>
    <div class="row">
        <template v-for="(item, key) in oTaskList">
            <todo-list-item
                :todoItem="item"
                :itemKey="key"
            ></todo-list-item>
        </template>
    </div>
</template>

<script>
import TodoListItem from "./TodoListItem";
import { mapState, mapActions } from 'vuex';
export default {
    name: "TodoList",
    components: {
        TodoListItem
    },
    mounted() {
        this.fetchTodoList();
    },
    computed: {
        ...mapState('taskModule', {
            oTaskList : state => state.taskList,
        }),
    },
    methods: {
        ...mapActions('taskModule',['fetchTodoList']),
    }
}
</script>

<style scoped>

</style>
