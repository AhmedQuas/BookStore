<div class="container">
    <div class="row mt-3">
        <div class="col-3">
            <a class="btn btn-primary ml-3" href="/">{{config('app.name')}}</a>
        </div>
        <nav class="col-9">
            <ul class="nav justify-content-end">
                <li class="nav-item mx-4">
                    <a class="nav-link btn btn-outline-primary" href="/books">Show books</a>
                </li>
                <li class="nav-item dropdown mr-3">
                    <button class="btn btn-primary dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admin panel
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="/books/create">Add new book</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div class="mx-4">
        @include('inc.messages')
    </div>
</div>
