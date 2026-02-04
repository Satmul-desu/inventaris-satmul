@extends('layouts.admin')

@section('title', 'Sandbox - Q&A')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fa fa-comments"></i> Sandbox - Tanya Jawab
            </h4>
            @if(auth()->user()->isOwner())
            <button class="btn btn-primary" data-toggle="modal" data-target="#newQuestionModal">
                <i class="fa fa-plus"></i> Pertanyaan Baru
            </button>
            @endif
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ !request('filter') && !request('status') ? 'active' : '' }}" href="{{ route('admin.sandbox.index') }}">
                    Semua
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'open' ? 'active' : '' }}" href="{{ route('admin.sandbox.filter', 'open') }}">
                    <i class="fa fa-question-circle text-warning"></i> Belum Dijawab
                    @php $unansweredCount = $threads->where('status', 'open')->whereNull('parent_id')->count(); @endphp
                    @if($unansweredCount > 0)
                    <span class="badge badge-warning">{{ $unansweredCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'answered' ? 'active' : '' }}" href="{{ route('admin.sandbox.filter', 'answered') }}">
                    <i class="fa fa-check-circle text-success"></i> Sudah Dijawab
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'closed' ? 'active' : '' }}" href="{{ route('admin.sandbox.filter', 'closed') }}">
                    <i class="fa fa-lock text-secondary"></i> Ditutup
                </a>
            </li>
        </ul>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
        @endif

        <!-- Thread List -->
        <div class="list-group">
            @forelse($threads as $thread)
            <a href="{{ route('admin.sandbox.show', $thread->id) }}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <div>
                        @if($thread->is_pinned)
                        <span class="badge badge-danger mr-2"><i class="fa fa-thumbtack"></i> Dipin</span>
                        @endif
                        @if($thread->priority === 'high')
                        <span class="badge badge-warning mr-2"><i class="fa fa-exclamation"></i> Penting</span>
                        @endif
                        @if($thread->status === 'open')
                        <span class="badge badge-warning mr-2">Belum Dijawab</span>
                        @elseif($thread->status === 'answered')
                        <span class="badge badge-success mr-2">Sudah Dijawab</span>
                        @else
                        <span class="badge badge-secondary mr-2">Ditutup</span>
                        @endif
                        <h5 class="mb-1 d-inline">{{ $thread->subject ?: 'Tanpa Subjek' }}</h5>
                    </div>
                    <small class="text-muted">
                        {{ $thread->created_at->diffForHumans() }}
                    </small>
                </div>
                <p class="mb-1">{{ \Illuminate\Support\Str::limit($thread->message, 150) }}</p>
                <small class="text-muted">
                    <i class="fa fa-user"></i> {{ $thread->sender->name ?? 'Unknown' }}
                    @if($thread->replies->count() > 0)
                    <span class="ml-3"><i class="fa fa-comments"></i> {{ $thread->replies->count() }} jawaban</span>
                    @endif
                </small>
            </a>
            @empty
            <div class="text-center py-5">
                <i class="fa fa-comments-o fa-4x text-muted mb-3"></i>
                <p class="text-muted">Belum ada pertanyaan.</p>
                @if(auth()->user()->isOwner())
                <button class="btn btn-primary" data-toggle="modal" data-target="#newQuestionModal">
                    <i class="fa fa-plus"></i> Ajukan Pertanyaan Pertama
                </button>
                @endif
            </div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $threads->links() }}
        </div>
    </div>
</div>

<!-- Modal Pertanyaan Baru -->
@if(auth()->user()->isOwner())
<div class="modal fade" id="newQuestionModal" tabindex="-1" role="dialog" aria-labelledby="newQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newQuestionModalLabel">
                    <i class="fa fa-plus-circle text-primary"></i> Ajukan Pertanyaan Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.sandbox.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject">Subjek / Topik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                               id="subject" name="subject" placeholder="Contoh: Cara input barang baru" required>
                        @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message">Pertanyaan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="5" 
                                  placeholder="Jelaskan pertanyaan Anda dengan detail..." required></textarea>
                        @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="priority">Prioritas</label>
                        <select class="form-control" id="priority" name="priority">
                            <option value="normal">Normal</option>
                            <option value="high">Penting</option>
                            <option value="low">Rendah</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-send"></i> Kirim Pertanyaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

