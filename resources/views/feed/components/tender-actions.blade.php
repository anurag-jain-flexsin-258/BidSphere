<div class="d-flex justify-content-between align-items-center border-top pt-3">

    {{-- Like Button --}}
    @auth('customer')
        <button class="btn btn-sm btn-outline-primary like-btn" data-id="{{ $tender->id }}">
            👍 Like
        </button>
    @else
        <a href="{{ route('customer.login') }}" class="btn btn-sm btn-outline-secondary">
            Login to Like
        </a>
    @endauth

    {{-- View Details --}}
    <a href="{{ route('feed.show', $tender) }}" class="btn btn-sm btn-primary">
        View Details
    </a>
</div>

@auth('customer')
<script>
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('like-btn')) {
        const button = e.target;
        const tenderId = button.dataset.id;

        axios.post(`/customer/feed/${tenderId}/like`)
            .then(res => {
                if(res.data.success){
                    // Update likes count in card
                    const likesSpan = button.closest('.card-body').querySelector('span:nth-child(2)');
                    if(likesSpan) likesSpan.textContent = `👍 ${res.data.likes_count} likes`;
                }
            });
    }
});
</script>
@endauth