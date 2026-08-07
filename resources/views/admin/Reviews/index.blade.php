@extends('layouts.admin.app')

@section('title', 'Reviews')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Customer Reviews</h3>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Verified Purchase</th>
                            <th>Created At</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($reviews as $review)

                            <tr>

                                <td>{{ $review->id }}</td>

                                <td>
                                    {{ $review->user->name }}
                                </td>

                                <td>
                                    {{ $review->product->name }}
                                </td>

                                <td>
                                    @for($i=1;$i<=5;$i++)
                                        @if($i <= $review->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </td>

                                <td style="max-width:300px">
                                    {{ Str::limit($review->comment,80) }}
                                </td>

                                <td>

                                    @if($review->is_approved)

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @else

                                        <span class="badge bg-warning">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($review->is_verified)

                                        <span class="badge bg-primary">
                                            Verified
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Unverified
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $review->created_at->format('Y-m-d') }}
                                </td>

                                <td>

                                    @if(!$review->is_approved)

                                        <form action="{{ route('admin.reviews.approve',$review) }}"
                                              method="POST"
                                              class="d-inline">

                                            @csrf
                                            @method('PATCH')

                                            <button class="btn btn-success btn-sm">
                                                Approve
                                            </button>

                                        </form>

                                    @endif

                                   

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="text-center">
                                    No Reviews Found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $reviews->links() }}
            </div>

        </div>

    </div>

</div>

@endsection