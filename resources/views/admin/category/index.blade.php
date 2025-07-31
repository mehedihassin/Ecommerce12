@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Categories</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index.html">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Categories</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                       <form class="form-search" id="liveSearchForm">
                            <fieldset class="name ">
                                <input type="text" id="searchInput" placeholder="Search here..." name="name"
                                    autocomplete="off">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.category.create') }}"><i
                            class="icon-plus"></i>Add new</a>
                </div>
                <div class="wg-table table-all-user">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        @php
                            $i = 1;
                        @endphp
                        <tbody>
                            <tr>
                                @foreach ($categories as $category)
                                    <td>{{ $i++ }}</td>
                                    <td class="pname">
                                        <div class="image">
                                            @if ($category->image)
                                                <img src="data:image/jpeg;base64,{{ base64_encode($category->image) }}"
                                                    alt="" class="image"
                                                    style="height: 60px; width: auto; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <img src="{{ asset('default-image.jpg') }}" alt="No image" class="image"
                                                    style="height: 60px;">
                                            @endif
                                        </div>
                                        <div class="name">
                                            <a href="#" class="body-title-2">{{ $category->name ?? '' }}</a>
                                        </div>
                                    </td>

                                    <td>{{ $category->slug ?? '' }}</td>
                                    <td><a href="#" target="_blank">2</a></td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{ route('admin.category.edit', $category->id) }}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{ route('admin.category.delete', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="item text-danger delete"
                                                    style="background: none; border: none; padding: 0; cursor: pointer;">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $categories->links() !!}
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                // Get name and slug text (adjust cell indexes as needed)
                const name = row.cells[1].textContent.toLowerCase();
                const slug = row.cells[2].textContent.toLowerCase();

                // Check if name or slug contains filter text
                if (name.includes(filter) || slug.includes(filter)) {
                    row.style.display = ''; // show row
                } else {
                    row.style.display = 'none'; // hide row
                }
            });
        });
    </script>
@endpush
