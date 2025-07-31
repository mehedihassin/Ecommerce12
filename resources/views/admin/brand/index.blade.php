@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Brands</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Brands</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search" id="liveSearchForm">
                            <fieldset class="name">
                                <input type="text" id="searchInput" placeholder="Search here..." name="name"
                                    autocomplete="off">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>

                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.brands.create') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Images</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @php
                                $i = 1;
                            @endphp

                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $brand->name ?? '' }}</td>
                                        <td>{{ $brand->slug ?? '' }}</td>
                                        <td style="max-width: 100px;">
                                            <div style="overflow-x: auto; white-space: nowrap;">
                                                @foreach ($brand->images as $image)
                                                    <img src="data:image/jpeg;base64,{{ base64_encode($image->image) }}"
                                                        style="height: 50px; width: auto; object-fit: cover; margin-right: 5px; border-radius: 4px;">
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Edit Button -->
                                                <a class="btn btn-outline-info "
                                                    href="{{ route('admin.brands.edit', $brand->id) }}" title="Edit">
                                                    <i class="icon-edit"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action=" {{ route('admin.brands.delete', $brand->id) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                        <i class="icon-trash"></i>
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
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $brands->links() !!}
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
