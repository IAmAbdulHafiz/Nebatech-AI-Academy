<?php
/**
 * Unified Testimonials Component
 * Displays testimonials from both courses and services
 */

use Nebatech\Services\TestimonialService;

// Get component parameters
$testimonialType = $testimonialType ?? 'mixed'; // mixed, course, service, featured
$limit = $limit ?? 6;
$showTitle = $showTitle ?? true;
$layout = $layout ?? 'grid'; // grid, carousel, list
$relatedId = $relatedId ?? null;
$relatedType = $relatedType ?? null;

$testimonialService = new TestimonialService();

// Get testimonials based on type
switch ($testimonialType) {
    case 'featured':
        $testimonials = $testimonialService->getFeaturedTestimonials($limit);
        break;
    case 'mixed':
        $testimonials = $testimonialService->getMixedTestimonials($limit);
        break;
    case 'success_stories':
        $testimonials = $testimonialService->getSuccessStories($limit);
        break;
    case 'content_specific':
        if ($relatedId && $relatedType) {
            $testimonials = $testimonialService->getContentTestimonials($relatedType, $relatedId, $limit);
        } else {
            $testimonials = [];
        }
        break;
    default:
        $testimonials = $testimonialService->getTestimonials([
            'type' => $testimonialType,
            'limit' => $limit
        ]);
}

if (empty($testimonials)) {
    return;
}

$sectionTitle = $sectionTitle ?? 'What Our Community Says';
$sectionSubtitle = $sectionSubtitle ?? 'Success stories from students and clients who transformed their careers with Nebatech';
?>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <?php if ($showTitle): ?>
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    <?= htmlspecialchars($sectionTitle) ?>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    <?= htmlspecialchars($sectionSubtitle) ?>
                </p>
            </div>
        <?php endif; ?>
        
        <?php if ($layout === 'carousel'): ?>
            <!-- Carousel Layout -->
            <div class="relative" x-data="testimonialCarousel()">
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out" 
                         :style="`transform: translateX(-${currentSlide * 100}%)`">
                        <?php foreach ($testimonials as $index => $testimonial): ?>
                            <div class="w-full flex-shrink-0 px-4">
                                <?php include __DIR__ . '/testimonial-card.php'; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="flex justify-center mt-8 space-x-2">
                    <?php foreach ($testimonials as $index => $testimonial): ?>
                        <button @click="currentSlide = <?= $index ?>"
                                :class="currentSlide === <?= $index ?> ? 'bg-primary' : 'bg-gray-300'"
                                class="w-3 h-3 rounded-full transition-colors">
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <!-- Arrow Navigation -->
                <button @click="previousSlide()" 
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:shadow-xl transition-shadow">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="nextSlide()"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:shadow-xl transition-shadow">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            
        <?php elseif ($layout === 'list'): ?>
            <!-- List Layout -->
            <div class="max-w-4xl mx-auto space-y-8">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                        <?php include __DIR__ . '/testimonial-content.php'; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
        <?php else: ?>
            <!-- Grid Layout (Default) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($testimonials as $testimonial): ?>
                    <?php include __DIR__ . '/testimonial-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Call to Action -->
        <?php if ($testimonialType === 'mixed' || $testimonialType === 'featured'): ?>
            <div class="text-center mt-12">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 max-w-2xl mx-auto">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Ready to Start Your Success Story?</h3>
                    <p class="text-gray-600 mb-6">Join thousands of students and clients who have transformed their careers with Nebatech.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?= url('/programmes') ?>" 
                           class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Start Learning
                        </a>
                        <a href="<?= url('/services') ?>" 
                           class="bg-secondary text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-600 transition-colors">
                            <i class="fas fa-briefcase mr-2"></i>
                            Get Professional Help
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if ($layout === 'carousel'): ?>
<script>
function testimonialCarousel() {
    return {
        currentSlide: 0,
        totalSlides: <?= count($testimonials) ?>,
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        
        previousSlide() {
            this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
        },
        
        init() {
            // Auto-advance slides every 5 seconds
            setInterval(() => {
                this.nextSlide();
            }, 5000);
        }
    }
}
</script>
<?php endif; ?>
