@extends('layout.app')

@section('content')
<main class="g-page-wrap">

    <div class="g-page-content-area">

        <div class="g-page-content-main">

            <!--**********************************
                    Visualization & Graph
             ***********************************-->
            <div class="container-fluid mb-3">
                <div class="g-chart-area">
                    <div class="g-chart-main">
                        <div class="card">
                            <canvas id="vdi-line-chart"></canvas>
                        </div>

                        <div class="card">
                            <canvas id="vdi-pie-chart"></canvas>
                        </div>
                    </div>


                </div>
            </div>

            <div class="container-fluid position-relative">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body p-0">

                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle table-striped align-middle table-sm">
                                        <thead class="g-thead">
                                        <tr>
                                            <th scope="col">S/N</th>
                                            <th scope="col">Agent ID</th>
                                            <th scope="col">Alternative ID</th>
                                            <th scope="col">Nick Name</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Skills</th>
                                            <th scope="col">DID</th>
                                            <th scope="col">Supervisor ID</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>1002</td>
                                            <td>10022145</td>
                                            <td>Iqbal</td>
                                            <td>Iqbal Ahmed</td>
                                            <td>Lorem ipsum dolor sit amet.</td>
                                            <td></td>
                                            <td></td>
                                            <td>Manager</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="g-table-action">
                                                    <span class="text-success"><i
                                                            class="bi bi-plus-square"></i></span>
                                                    <span class="text-primary"><i
                                                            class="bi bi-pencil-square"></i></span>
                                                    <span class="text-danger"><i
                                                            class="bi bi-trash3-fill"></i></span>
                                                </div>
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer bg-white text-center d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
                                <div class="g-page-count">
                                    Page <strong class="text-primary"> 8</strong> out of <strong
                                        class="text-primary"> 50</strong>
                                </div>

                                <div class="g-pagination">
                                    <nav aria-label="page navigation">
                                        <ul class="pagination pagination-sm mb-0">
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
                                    </nav>
                                </div>

                                <div class="g-page-c-dropdown">
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm">
                                        <option selected>10</option>
                                        <option value="1">50</option>
                                        <option value="2">100</option>
                                        <option value="3">150</option>
                                    </select>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>

@endsection
