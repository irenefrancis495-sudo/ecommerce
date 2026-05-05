<?php
// Handle form submission
$submitResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    $name    = trim(htmlspecialchars($_POST['name']    ?? '', ENT_QUOTES, 'UTF-8'));
    $email   = trim(htmlspecialchars($_POST['email']   ?? '', ENT_QUOTES, 'UTF-8'));
    $subject = trim(htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES, 'UTF-8'));
    $message = trim(htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8'));

    if (!$name || !$email || !$subject || !$message) {
        $submitResult = ['success' => false, 'msg' => 'Please fill in all required fields.'];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $submitResult = ['success' => false, 'msg' => 'Please enter a valid email address.'];
    } else {
        $file     = __DIR__ . '/../data/contact_messages.json';
        $messages = json_decode(file_get_contents($file), true) ?: [];
        $messages[] = [
            'id'         => count($messages) + 1,
            'name'       => $name,
            'email'      => $email,
            'subject'    => $subject,
            'message'    => $message,
            'status'     => 'new',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));
        $submitResult = ['success' => true, 'msg' => 'Thank you, ' . $name . '! Your message has been received. We\'ll get back to you within 24 hours.'];
    }
}
?>
<?php include __DIR__ . '/../components/ui/navbar.php'; ?>

<main class="min-h-screen">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 pt-32 pb-20">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-2 text-sm font-semibold text-primary mb-6">
                <span class="material-symbols-outlined text-base">mail</span>
                Get In Touch
            </span>
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-6">Contact Us</h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">Have questions or need assistance? We're here to help. Reach out to our team anytime.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid gap-12 lg:grid-cols-3">
            <!-- Contact Info -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Email -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 text-primary mb-4">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Email</h3>
                    <p class="text-slate-600 text-sm">contact@mpembamarketplace.com</p>
                    <p class="text-slate-600 text-sm mt-1">support@mpembamarketplace.com</p>
                    <p class="text-xs text-slate-500 mt-3">Response time: 24 hours</p>
                </div>

                <!-- Phone -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 text-primary mb-4">
                        <span class="material-symbols-outlined">phone</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Phone</h3>
                    <p class="text-slate-600 text-sm">+1 (555) 123-4567</p>
                    <p class="text-xs text-slate-500 mt-3">Mon - Fri, 9AM - 6PM EST</p>
                </div>

                <!-- Address -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 text-primary mb-4">
                        <span class="material-symbols-outlined">location_on</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Office</h3>
                    <p class="text-slate-600 text-sm">Mpemba Marketplace Inc.<br/>The Digital Atelier<br/>New York, NY 10001</p>
                </div>

                <!-- Social -->
                <div class="rounded-2xl bg-gradient-to-br from-primary/10 to-cyan-500/10 border border-primary/20 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="#" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-primary text-white hover:bg-primary/90 transition">
                            <span class="material-symbols-outlined text-base">public</span>
                        </a>
                        <a href="#" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-primary text-white hover:bg-primary/90 transition">
                            <span class="material-symbols-outlined text-base">public</span>
                        </a>
                        <a href="#" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-primary text-white hover:bg-primary/90 transition">
                            <span class="material-symbols-outlined text-base">public</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2 rounded-3xl border border-slate-200 bg-white p-8 lg:p-12">
                <h2 class="text-2xl font-black text-slate-900 mb-8">Send us a Message</h2>
                <form class="grid gap-6" method="POST" action="/contact">
                    <input type="hidden" name="contact_form" value="1" />
                    <!-- Name -->
                    <div class="grid gap-2">
                        <label class="text-sm font-semibold text-slate-900">Full Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="John Doe" required class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary" />
                    </div>

                    <!-- Email -->
                    <div class="grid gap-2">
                        <label class="text-sm font-semibold text-slate-900">Email Address</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="john@example.com" required class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary" />
                    </div>

                    <!-- Subject -->
                    <div class="grid gap-2">
                        <label class="text-sm font-semibold text-slate-900">Subject</label>
                        <select name="subject" required class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary">
                            <option value="">Select a subject</option>
                            <?php foreach (['general' => 'General Inquiry', 'order' => 'Order & Shipping', 'return' => 'Returns & Refunds', 'artisan' => 'Artisan Partnership', 'media' => 'Media & Press', 'other' => 'Other'] as $val => $label): ?>
                            <option value="<?= $val ?>" <?= (($_POST['subject'] ?? '') === $val) ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Message -->
                    <div class="grid gap-2">
                        <label class="text-sm font-semibold text-slate-900">Message</label>
                        <textarea name="message" placeholder="Tell us how we can help..." rows="6" required class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary resize-none"><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <!-- Checkbox -->
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="agree" name="agree" required class="mt-1 rounded cursor-pointer" />
                        <label for="agree" class="text-sm text-slate-600">
                            I agree to the <a href="/privacy-policy" class="text-primary underline">privacy policy</a> and consent to being contacted via email.
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" id="submitBtn" class="mt-4 w-full rounded-xl bg-primary text-white px-6 py-3 font-bold hover:bg-primary/90 transition flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">send</span>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="max-w-4xl mx-auto px-6 pb-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-slate-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-slate-600">Find quick answers to common questions</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ 1 -->
            <details class="rounded-xl border border-slate-200 bg-white p-6 group cursor-pointer">
                <summary class="flex items-center justify-between font-bold text-slate-900">
                    <span>What is your shipping timeframe?</span>
                    <span class="material-symbols-outlined text-slate-500 group-open:rotate-180 transition-transform">expand_more</span>
                </summary>
                <p class="mt-4 text-slate-600 text-sm">We offer standard shipping (5-7 business days) and express shipping (2-3 business days) options. International orders typically arrive within 10-14 business days.</p>
            </details>

            <!-- FAQ 2 -->
            <details class="rounded-xl border border-slate-200 bg-white p-6 group cursor-pointer">
                <summary class="flex items-center justify-between font-bold text-slate-900">
                    <span>Do you offer international shipping?</span>
                    <span class="material-symbols-outlined text-slate-500 group-open:rotate-180 transition-transform">expand_more</span>
                </summary>
                <p class="mt-4 text-slate-600 text-sm">Yes! We ship to over 100 countries worldwide. Shipping rates and delivery times vary by destination. All customs duties are the customer's responsibility.</p>
            </details>

            <!-- FAQ 3 -->
            <details class="rounded-xl border border-slate-200 bg-white p-6 group cursor-pointer">
                <summary class="flex items-center justify-between font-bold text-slate-900">
                    <span>What is your return policy?</span>
                    <span class="material-symbols-outlined text-slate-500 group-open:rotate-180 transition-transform">expand_more</span>
                </summary>
                <p class="mt-4 text-slate-600 text-sm">We accept returns within 30 days of purchase for a full refund or exchange. Items must be unused and in original condition. Return shipping is complimentary.</p>
            </details>

            <!-- FAQ 4 -->
            <details class="rounded-xl border border-slate-200 bg-white p-6 group cursor-pointer">
                <summary class="flex items-center justify-between font-bold text-slate-900">
                    <span>How can I become an artisan partner?</span>
                    <span class="material-symbols-outlined text-slate-500 group-open:rotate-180 transition-transform">expand_more</span>
                </summary>
                <p class="mt-4 text-slate-600 text-sm">We're always looking for talented artisans! Please email us at artisans@mpembamarketplace.com with samples of your work and a brief description of your craft. Our team will review applications within 2 weeks.</p>
            </details>

            <!-- FAQ 5 -->
            <details class="rounded-xl border border-slate-200 bg-white p-6 group cursor-pointer">
                <summary class="flex items-center justify-between font-bold text-slate-900">
                    <span>Are your products authentic?</span>
                    <span class="material-symbols-outlined text-slate-500 group-open:rotate-180 transition-transform">expand_more</span>
                </summary>
                <p class="mt-4 text-slate-600 text-sm">100% authentic! Every product on Mpemba Marketplace is handcrafted by verified artisans. We carefully vet each seller to ensure authenticity and fair labor practices.</p>
            </details>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>

<script src="/assets/sweetalert2/sweetalert2.all.min.js"></script>
<?php if ($submitResult): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php if ($submitResult['success']): ?>
    Swal.fire({
        icon: 'success',
        title: 'Message Sent!',
        text: <?= json_encode($submitResult['msg']) ?>,
        confirmButtonColor: 'var(--color-primary)',
        confirmButtonText: 'Great, thanks!'
    });
    <?php else: ?>
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: <?= json_encode($submitResult['msg']) ?>,
        confirmButtonColor: 'var(--color-primary)'
    });
    <?php endif; ?>
});
</script>
<?php endif; ?>
