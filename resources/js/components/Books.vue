<template>

    <div class="container">
       
        <h2 class="text-center">Books</h2>
<form class="mb-3" @submit.prevent="searchBook()">
           
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="search with title " ref="my_input">
                </div>
           
            <button class=" mb-2 btn btn-outline-info col-12">
                 Search
            </button> 
        </form>
        <form class="mb-3" @submit.prevent="addBook">
           
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="title " v-model="book.title">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="author " v-model="book.author">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="price " v-model="book.price">
                </div>
            <button class=" mb-2 btn btn-outline-success col-12">
                 Update/Add
            </button> 
        </form>
        <div class="card card-body mb-4" v-for="book in books" v-bind:key="book.id">
          
            <h3><span class="text-secondary">Title:</span>  {{book.title}}  </h3>
            <p><span class="text-secondary">Author:</span>{{book.author}}</p>
            <p><span class="text-secondary">Price:</span>{{book.price}}</p>
               <button class=" btn btn-outline-info mb-1"  @click="editBook(book)">
                 Edit
            </button> 
            <button class=" btn btn-outline-danger"  @click="deleteBook(book.id)">
                 Delete
            </button> 
        </div>
    </div>
</template>

<script>

export default {
    data() {
      return{
        books: [],
        book:{
            id :'',
            title:'',
            author:'',
            price:''

        },
       book_id :'',
       pagination :{},
       edit :false 
    };
},
created(){
this.fetchBooks();
},

methods :{
   async fetchBooks(){
    const a=await  fetch('api/books')
                   .then(respone=>respone.json());
 
    this.books=a;
        

    },
       async searchBook(){
    const a=await  fetch(`api/books/kerko/${this.$refs.my_input.value}`)
                   .then(respone=>respone.json());
 
    this.books=a;
        

    },
        
        deleteBook(id){
            if(confirm("Are you sure?")){

                fetch(`api/books/${id}`,{
                   
                   method:'DELETE',
                    headers:{
                    Accept: 'application/json',
                    'Content-Type':'application/json',
                    '_method':'DELETE',
                    'Authorization':'',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                })
                .then(response=>response.json())
                .then(res=>{
                    console.log(res);
                    if(res.message=='Unauthenticated.')
                    alert("You are unauthenticated!\nBook not removed");
                    else
                    alert("Book removed");
                    this.fetchBooks();
                })   
                .catch(err=>{
                    alert("error occured");
                    console.log(err);})
            }
        },

        addBook(){
            if(this.edit===false){
                //add
                fetch('api/books',{
                method:'POST',
                body:JSON.stringify(this.book),
                headers:{
                    'Content-Type':'application/json',
                    Accept: 'application/json',
                    '_method':'POST',
                    'Authorization':'',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                })
                .then(res=>res.json())
                .then(res=>{
                    console.log(res);
                    this.book.title='';
                    this.book.author='';
                    this.book.price='';
                    if(res.message=='Unauthenticated.')
                    alert("You are unauthenticated!\nBook not added");
                    else
                    alert("Book added");
                    this.fetchBooks();
                })
                .catch(err=>{
                    alert("error occured");
                    console.log(err);})
            

            }
            else{
                //update
                 fetch(`api/books/${this.book.id}`,{
                method:'PUT',
                body:JSON.stringify(this.book),
                headers:{
                     'Content-Type':'application/json',
                    Accept: 'application/json',
                    '_method':'PUT',
                    'Authorization':'',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }
                })
                .then(res=>res.json())
                .then(res=>{
                    console.log(res.message);
                    this.book.title='';
                    this.book.author='';
                    this.book.price='';
                    if(res.message=='Unauthenticated.')
                    alert("You are unauthenticated!\nBook not updated");
                    else
                    alert("Book updated");
                    this.fetchBooks();
                })
                .catch(err=>{
                    alert("error occured");
                    console.log(err);})
            }

        },
        editBook(book){
            this.edit=true;
            this.book.id=book.id;
            this.book.book_id=book.id;
            this.book.title=book.title;
            this.book.author=book.author;
            this.book.price=book.price;
        }

}
}


</script>
