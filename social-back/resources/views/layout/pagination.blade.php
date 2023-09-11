<div class="card-footer bg-white text-center d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
    <div class="g-page-count">
        Page <strong class="text-primary"> {{$dataPack->data->currentPage()}}</strong> out of <strong
            class="text-primary"> {{$dataPack->data->lastPage()}}</strong>
    </div>
    <div class="g-pagination">
        {{$dataPack->data->links('vendor.pagination.default')}}
        {{-- <nav >
            <ul class="pagination mb-0">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item active" aria-current="page">
                    <span class="page-link">1</span>
                </li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav> --}}
    </div>
    
    <div class="g-page-c-dropdown">
        <select onchange="setPaginateLimit(this)" class="form-select form-select-sm" aria-label=".form-select-sm">
            <option value="30" <?php echo $dataPack->perPage == 30 ? 'selected' : '' ?>>30</option>
            <option value="100" <?php echo $dataPack->perPage == 100 ? 'selected' : '' ?>>100</option>
            <option value="150" <?php echo $dataPack->perPage == 150 ? 'selected' : '' ?>>150</option>
        </select>
    </div>

</div>

@section('pagination')
    <script>
        function setPaginateLimit(t){
            var currentUrl  = '{{Request::url()}}';
            var currentPage = '{{$dataPack->data->currentPage()}}';
            window.location.href = currentUrl + '?page=' + currentPage + '&perPage=' + t.value;
        }
    </script>
@endsection