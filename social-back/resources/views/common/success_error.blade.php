@if(session()->has('success'))
<div
    class="toast show toast-placement align-items-center text-white bg-success border-0  {{session()->get('success')}}"
    role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            {{session()->get('success')}}
        </div>
        <button type="button"
                class="btn-close btn-close-white me-2 m-auto close"
                data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

@endif
@if(session()->has('error'))
<div
    class="toast show toast-placement align-items-center text-white bg-danger border-0  {{session()->get('error')}}"
    role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            {{session()->get('error')}}
        </div>
        <button type="button"
                class="btn-close btn-close-white me-2 m-auto close"
                data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
@endif
