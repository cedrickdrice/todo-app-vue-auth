<template>
    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 p-0">
        <div class="">
            <div class="two">
                <div class="d-flex justify-content-end px-3 pt-3"><i class="mdi mdi-star-outline pr-1 star"></i><i class="mdi mdi-dots-horizontal dot"></i></div>
                <div class="px-3 pt-3 pb-1">
                    <h3 class="name">{{ todoItem.title }}</h3>
                    <p class="quote2 mb-1">{{ todoItem.description }}</p>
                </div>
                <div class="px-3 text-left">
                    <fa icon="bookmark" class="fa-fw text-danger" aria-hidden="true"></fa>
                    <fa v-if="todoItem.due_date !== ''" icon="calendar-minus" class="fa-fw text-muted" aria-hidden="true"></fa>
                    <span v-if="todoItem.due_date !== ''" class="quote2 pl-1">Due: {{ todoItem.due_date }}</span>
                </div>
                <div class="px-3 text-left">
                    <span class="badge badge-danger">Danger</span>
                </div>
                <div class="d-flex justify-content-between  px-3 align-items-center pb-4">
                    <div class="d-flex justify-content-start align-items-center">
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TodoListItem",
    props: ['todoItem', 'itemKey']
}
</script>

<style scoped>

</style>
