-- Nebatech AI Academy - Blog System Sample Data Seeder
-- Run this after creating the main schema tables

-- ============================================
-- 1. BLOG CATEGORIES
-- ============================================

INSERT INTO blog_categories (name, slug, color, status, created_at) VALUES
('AI & Machine Learning', 'ai-machine-learning', '#002060', 'active', NOW()),
('Career Development', 'career-development', '#FF5722', 'active', NOW()),
('Tutorials', 'tutorials', '#4CAF50', 'active', NOW()),
('Industry News', 'industry-news', '#2196F3', 'active', NOW()),
('Student Success', 'student-success', '#FF9800', 'active', NOW()),
('Tech Skills', 'tech-skills', '#9C27B0', 'active', NOW());

-- ============================================
-- 2. SAMPLE BLOG POSTS
-- ============================================

INSERT INTO blog_posts (uuid, title, slug, excerpt, content, author_id, category_id, tags, views, is_featured, status, published_at, created_at, updated_at) VALUES

-- Featured Post
(UUID(), 
'The Future of AI in Africa: Why Ghana is Leading the Tech Revolution', 
'future-of-ai-in-africa',
'Discover how Ghana is becoming a tech hub and why AI education is crucial for Africa\'s future.',
'<h2>Ghana\'s Emerging Tech Ecosystem</h2>
<p>Ghana is rapidly positioning itself as a leading technology hub in West Africa. With a growing number of tech startups, increased investment in digital infrastructure, and a young, tech-savvy population, the country is poised to lead Africa\'s AI revolution.</p>

<h2>Why AI Education Matters</h2>
<p>As artificial intelligence continues to transform industries globally, African nations have a unique opportunity to leapfrog traditional development models. By investing in AI education and skills training, Ghana can prepare its workforce for the jobs of tomorrow.</p>

<h2>Nebatech\'s Role in the Revolution</h2>
<p>At Nebatech AI Academy, we\'re committed to democratizing AI education. Our programs are designed specifically for African learners, addressing real-world challenges and opportunities in our local context.</p>

<h3>Key Areas of Focus:</h3>
<ul>
<li><strong>Machine Learning Fundamentals:</strong> Building a strong foundation in ML algorithms and applications</li>
<li><strong>Natural Language Processing:</strong> Enabling AI to understand and process African languages</li>
<li><strong>Computer Vision:</strong> Solving visual recognition challenges in African contexts</li>
<li><strong>Data Science:</strong> Extracting insights from Africa-specific datasets</li>
</ul>

<h2>Success Stories</h2>
<p>Our students are already making an impact. From building agricultural AI solutions to creating healthcare diagnostics tools, they\'re proving that African innovation can compete globally.</p>

<blockquote>
"The future of AI is not just in Silicon Valley – it\'s being written right here in Accra, Lagos, Nairobi, and across the continent." - Dr. Kwame Mensah, Tech Innovator
</blockquote>

<h2>Join the Movement</h2>
<p>Whether you\'re a complete beginner or looking to advance your AI skills, there\'s never been a better time to start. The AI revolution is here – and Africa must be part of it.</p>',
1, 1, 
'["AI", "Ghana", "Africa", "Technology", "Innovation", "Future"]',
1247, 1, 'published', NOW(), NOW(), NOW()),

-- Tutorial Posts
(UUID(), 
'Getting Started with Python for AI: A Beginner\'s Guide', 
'getting-started-python-ai',
'Learn the fundamentals of Python programming and why it\'s the go-to language for AI development.',
'<h2>Why Python for AI?</h2>
<p>Python has become the de facto language for artificial intelligence and machine learning. Its simple syntax, extensive libraries, and strong community support make it ideal for both beginners and experts.</p>

<h2>Essential Python Libraries for AI</h2>
<ul>
<li><strong>NumPy:</strong> Numerical computing with powerful array operations</li>
<li><strong>Pandas:</strong> Data manipulation and analysis</li>
<li><strong>Scikit-learn:</strong> Machine learning algorithms and tools</li>
<li><strong>TensorFlow/PyTorch:</strong> Deep learning frameworks</li>
<li><strong>Matplotlib/Seaborn:</strong> Data visualization</li>
</ul>

<h2>Your First Python AI Project</h2>
<pre><code>
import numpy as np
from sklearn.linear_model import LinearRegression

# Sample data
X = np.array([[1], [2], [3], [4], [5]])
y = np.array([2, 4, 6, 8, 10])

# Create and train model
model = LinearRegression()
model.fit(X, y)

# Make prediction
prediction = model.predict([[6]])
print(f"Predicted value: {prediction[0]}")
</code></pre>

<h2>Next Steps</h2>
<p>This is just the beginning. Practice regularly, build projects, and join our community to accelerate your learning journey.</p>',
1, 3,
'["Python", "Programming", "Tutorial", "Beginners", "AI"]',
856, 0, 'published', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),

(UUID(), 
'10 Machine Learning Algorithms Every Data Scientist Should Know', 
'10-ml-algorithms-data-scientists',
'Master these fundamental machine learning algorithms to build powerful predictive models.',
'<h2>Essential ML Algorithms</h2>
<p>Machine learning offers a vast array of algorithms, but mastering these 10 will give you a solid foundation for most real-world problems.</p>

<h3>1. Linear Regression</h3>
<p>Perfect for predicting continuous values. Use cases: house price prediction, sales forecasting.</p>

<h3>2. Logistic Regression</h3>
<p>Despite its name, it\'s used for classification. Great for binary outcomes like spam detection.</p>

<h3>3. Decision Trees</h3>
<p>Intuitive and interpretable. Excellent for both classification and regression tasks.</p>

<h3>4. Random Forests</h3>
<p>An ensemble of decision trees that reduces overfitting and improves accuracy.</p>

<h3>5. Support Vector Machines (SVM)</h3>
<p>Powerful for classification, especially in high-dimensional spaces.</p>

<h3>6. K-Nearest Neighbors (KNN)</h3>
<p>Simple yet effective for both classification and regression.</p>

<h3>7. Naive Bayes</h3>
<p>Fast and efficient for text classification and spam filtering.</p>

<h3>8. Neural Networks</h3>
<p>The foundation of deep learning. Capable of learning complex patterns.</p>

<h3>9. K-Means Clustering</h3>
<p>Unsupervised learning for grouping similar data points.</p>

<h3>10. Gradient Boosting (XGBoost/LightGBM)</h3>
<p>State-of-the-art for structured data competitions and real-world applications.</p>

<h2>How to Choose?</h2>
<p>The best algorithm depends on your data, problem type, and constraints. Start simple, experiment, and iterate.</p>',
1, 3,
'["Machine Learning", "Algorithms", "Data Science", "Tutorial"]',
1092, 0, 'published', DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY), NOW()),

-- Career Development Posts
(UUID(), 
'From Zero to AI Engineer: A Realistic 6-Month Roadmap', 
'zero-to-ai-engineer-roadmap',
'A practical, step-by-step guide to transition into an AI engineering career in just 6 months.',
'<h2>The Reality Check</h2>
<p>Becoming an AI engineer in 6 months is ambitious but achievable with focused effort. This roadmap is based on real students who successfully made the transition.</p>

<h2>Month 1-2: Foundations</h2>
<ul>
<li>Learn Python programming (4-6 hours/day)</li>
<li>Master NumPy, Pandas, Matplotlib</li>
<li>Understand basic statistics and linear algebra</li>
<li>Complete 3-5 beginner projects</li>
</ul>

<h2>Month 3-4: Machine Learning Core</h2>
<ul>
<li>Study ML algorithms and theory</li>
<li>Learn Scikit-learn library</li>
<li>Practice on Kaggle competitions</li>
<li>Build 2-3 end-to-end ML projects</li>
</ul>

<h2>Month 5-6: Deep Learning & Specialization</h2>
<ul>
<li>Master TensorFlow or PyTorch</li>
<li>Study neural networks and deep learning</li>
<li>Choose a specialization (NLP, Computer Vision, etc.)</li>
<li>Build portfolio projects showcasing your skills</li>
</ul>

<h2>Key Success Factors</h2>
<ol>
<li><strong>Consistency:</strong> Study daily, even if just 2-3 hours</li>
<li><strong>Projects:</strong> Build real applications, not just tutorials</li>
<li><strong>Community:</strong> Join study groups and forums</li>
<li><strong>Feedback:</strong> Get code reviews from experienced developers</li>
</ol>

<p class="highlight">Remember: It\'s not about being perfect – it\'s about consistent progress.</p>',
1, 2,
'["Career", "Learning Path", "AI Engineer", "Roadmap"]',
2341, 0, 'published', DATE_SUB(NOW(), INTERVAL 7 DAY), DATE_SUB(NOW(), INTERVAL 7 DAY), NOW()),

(UUID(), 
'How I Landed My First AI Job Without a Computer Science Degree', 
'first-ai-job-without-cs-degree',
'Real story from a Nebatech graduate who transitioned from teaching to AI engineering.',
'<h2>My Background</h2>
<p>I was a high school mathematics teacher with no formal computer science education. At 32, I decided to change careers – a decision that changed my life.</p>

<h2>The Journey</h2>
<p>I enrolled in Nebatech\'s AI Bootcamp while still teaching. Mornings were for students, evenings and weekends for coding. It wasn\'t easy, but it was worth it.</p>

<h3>What Worked:</h3>
<ul>
<li><strong>Leveraging My Math Background:</strong> My teaching experience helped me understand ML algorithms quickly</li>
<li><strong>Building Projects:</strong> I created an educational AI tool that got noticed</li>
<li><strong>Networking:</strong> Attended every tech meetup in Accra</li>
<li><strong>Contributing to Open Source:</strong> Showed my coding skills publicly</li>
</ul>

<h2>The Breakthrough</h2>
<p>After 8 months of learning, I applied to 47 positions. Got 3 interviews. One job offer. That\'s all I needed.</p>

<blockquote>
"They didn\'t care about my degree. They cared about what I could build and my ability to learn." - Ama Adjei, AI Engineer at TechCorp Ghana
</blockquote>

<h2>Advice for Career Changers</h2>
<ol>
<li>Your previous experience is valuable – use it</li>
<li>Focus on practical skills over theory</li>
<li>Build a portfolio that solves real problems</li>
<li>Network authentically, not transactionally</li>
<li>Be patient but persistent</li>
</ol>',
1, 2,
'["Career Change", "Success Story", "No Degree", "Inspiration"]',
1876, 0, 'published', DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_SUB(NOW(), INTERVAL 10 DAY), NOW()),

-- Industry News
(UUID(), 
'African AI Startups Raised $2.3B in 2024: What This Means for Tech Education', 
'african-ai-startups-funding-2024',
'Record-breaking investment in African AI companies signals a massive opportunity for skilled professionals.',
'<h2>The Investment Boom</h2>
<p>2024 marked a historic year for African tech, with AI startups raising $2.3 billion across the continent. This represents a 145% increase from 2023.</p>

<h2>Where the Money is Going</h2>
<ul>
<li><strong>Fintech AI:</strong> $780M (34%)</li>
<li><strong>AgriTech:</strong> $450M (20%)</li>
<li><strong>HealthTech:</strong> $380M (17%)</li>
<li><strong>EdTech:</strong> $290M (13%)</li>
<li><strong>Other:</strong> $370M (16%)</li>
</ul>

<h2>Job Market Impact</h2>
<p>With increased funding comes increased hiring. We\'re seeing unprecedented demand for:</p>
<ul>
<li>Machine Learning Engineers</li>
<li>Data Scientists</li>
<li>AI Product Managers</li>
<li>MLOps Engineers</li>
</ul>

<h3>Salary Ranges (Ghana, 2024):</h3>
<ul>
<li>Junior ML Engineer: GH₵ 48,000 - 72,000/year</li>
<li>Mid-level Data Scientist: GH₵ 84,000 - 120,000/year</li>
<li>Senior AI Engineer: GH₵ 144,000 - 240,000+/year</li>
</ul>

<h2>The Skills Gap</h2>
<p>Despite the investment boom, there\'s a critical shortage of AI talent. This is where quality education becomes crucial.</p>

<p class="highlight">Now is the perfect time to enter the AI field in Africa. The opportunities are real, and the timing couldn\'t be better.</p>',
1, 4,
'["Investment", "Startups", "Africa", "Jobs", "Industry"]',
945, 0, 'published', DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW()),

-- Student Success
(UUID(), 
'Meet Kwabena: From Unemployed Graduate to Lead AI Engineer at Jumia', 
'student-success-kwabena-jumia',
'How one determined graduate used Nebatech training to land his dream job at one of Africa\'s largest e-commerce platforms.',
'<h2>The Starting Point</h2>
<p>Kwabena graduated with a degree in Business Administration in 2022. After 14 months of job hunting with no luck, he decided to pivot into tech.</p>

<h2>The Transformation</h2>
<p>"I had no coding experience whatsoever," Kwabena recalls. "But I knew AI was the future, and Nebatech\'s program was designed for people like me."</p>

<h3>His Journey:</h3>
<ul>
<li><strong>Month 1-3:</strong> Intensive Python and ML fundamentals</li>
<li><strong>Month 4-6:</strong> Built 5 portfolio projects including a recommendation system</li>
<li><strong>Month 7:</strong> Applied to 23 positions, got 5 interviews</li>
<li><strong>Month 8:</strong> Landed junior role at local startup</li>
<li><strong>Month 18:</strong> Promoted to Lead AI Engineer at Jumia</li>
</ul>

<h2>The Secret Sauce</h2>
<p>When asked about his rapid success, Kwabena emphasizes three things:</p>
<ol>
<li><strong>Consistent Practice:</strong> Coded every single day, even when motivated</li>
<li><strong>Real Projects:</strong> Built solutions for actual problems, not just tutorials</li>
<li><strong>Community Support:</strong> Active in Nebatech community, helping others learn</li>
</ol>

<blockquote>
"Nebatech didn\'t just teach me technical skills. They taught me how to think like an engineer and solve problems systematically." - Kwabena Osei
</blockquote>

<h2>His Advice</h2>
<p>"Don\'t wait for the perfect moment. Start today. The tech industry doesn\'t care where you came from – only where you\'re going and what you can build."</p>',
1, 5,
'["Success Story", "Student", "Career Change", "Inspiration"]',
1567, 0, 'published', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),

-- Tech Skills
(UUID(), 
'5 Data Science Projects to Build Your Portfolio in 2025', 
'5-data-science-projects-portfolio',
'Hands-on projects that will make your portfolio stand out to employers.',
'<h2>Why Portfolio Projects Matter</h2>
<p>In data science, your projects speak louder than your resume. Here are 5 project ideas that demonstrate real-world skills employers seek.</p>

<h2>1. Predictive Analytics Dashboard</h2>
<p><strong>Skills:</strong> Python, Pandas, Plotly, Machine Learning</p>
<p>Build an interactive dashboard that predicts business metrics. Use real or synthetic data to forecast sales, customer churn, or inventory needs.</p>

<h2>2. Natural Language Processing Application</h2>
<p><strong>Skills:</strong> NLP, Sentiment Analysis, Text Classification</p>
<p>Create a tool that analyzes social media sentiment or classifies customer feedback. Bonus: Train on African language data.</p>

<h2>3. Computer Vision Solution</h2>
<p><strong>Skills:</strong> CNN, Image Processing, TensorFlow/PyTorch</p>
<p>Build an image classifier, object detector, or facial recognition system. Consider agricultural or healthcare applications relevant to Africa.</p>

<h2>4. Recommendation Engine</h2>
<p><strong>Skills:</strong> Collaborative Filtering, Content-Based Filtering</p>
<p>Develop a product or content recommendation system. Show how you handle cold start problems and improve recommendations over time.</p>

<h2>5. End-to-End ML Pipeline</h2>
<p><strong>Skills:</strong> MLOps, Docker, FastAPI, Cloud Deployment</p>
<p>Build a complete machine learning system from data collection to deployment. Include monitoring, versioning, and CI/CD.</p>

<h2>Key Success Factors</h2>
<ul>
<li>Clean, well-documented code on GitHub</li>
<li>Deployed application (not just notebooks)</li>
<li>Clear README explaining your approach</li>
<li>Blog post or video walkthrough</li>
</ul>',
1, 6,
'["Projects", "Portfolio", "Data Science", "Practical"]',
721, 0, 'published', DATE_SUB(NOW(), INTERVAL 4 DAY), DATE_SUB(NOW(), INTERVAL 4 DAY), NOW()),

-- Additional Posts
(UUID(), 
'Understanding Neural Networks: A Visual Guide', 
'understanding-neural-networks-visual-guide',
'Break down the complexity of neural networks with intuitive visualizations and simple explanations.',
'<h2>What Are Neural Networks?</h2>
<p>Neural networks are computing systems inspired by biological neural networks in animal brains. They\'re the foundation of deep learning and modern AI.</p>

<h2>Basic Structure</h2>
<p>A neural network consists of layers of interconnected nodes (neurons):</p>
<ul>
<li><strong>Input Layer:</strong> Receives the initial data</li>
<li><strong>Hidden Layers:</strong> Process and transform the data</li>
<li><strong>Output Layer:</strong> Produces the final prediction</li>
</ul>

<h2>How They Learn</h2>
<p>Neural networks learn through a process called backpropagation:</p>
<ol>
<li>Forward pass: Data flows through network, producing prediction</li>
<li>Calculate error: Compare prediction with actual answer</li>
<li>Backward pass: Adjust weights to reduce error</li>
<li>Repeat thousands of times</li>
</ol>

<h2>Real-World Applications</h2>
<ul>
<li>Image recognition (identifying objects in photos)</li>
<li>Speech recognition (converting speech to text)</li>
<li>Language translation (Google Translate)</li>
<li>Autonomous vehicles (self-driving cars)</li>
<li>Medical diagnosis (detecting diseases from scans)</li>
</ul>

<p>Start simple, experiment often, and build intuition through practice.</p>',
1, 3,
'["Neural Networks", "Deep Learning", "Tutorial", "Visualization"]',
634, 0, 'published', DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 6 DAY), NOW()),

(UUID(), 
'AI Ethics in Africa: Why It Matters More Than You Think', 
'ai-ethics-africa-importance',
'Exploring the unique ethical challenges and opportunities of AI development in African contexts.',
'<h2>The Ethics Gap</h2>
<p>As AI rapidly advances in Africa, we must ensure it\'s developed and deployed responsibly. The stakes are too high to get it wrong.</p>

<h2>Key Ethical Concerns</h2>

<h3>1. Bias and Fairness</h3>
<p>AI models trained on Western data may not work well for African populations. We need African data for African solutions.</p>

<h3>2. Privacy and Data Rights</h3>
<p>Who owns the data? How is it used? These questions are critical as AI systems collect more personal information.</p>

<h3>3. Job Displacement</h3>
<p>While AI creates jobs, it also eliminates others. How do we manage this transition fairly?</p>

<h3>4. Accessibility</h3>
<p>Ensuring AI benefits reach everyone, not just the wealthy or tech-savvy.</p>

<h2>African Solutions</h2>
<p>Rather than importing Western ethical frameworks wholesale, Africa has an opportunity to develop AI ethics grounded in our values:</p>
<ul>
<li><strong>Ubuntu Philosophy:</strong> "I am because we are" - community-centered AI</li>
<li><strong>Inclusivity:</strong> Diverse languages, cultures, and contexts</li>
<li><strong>Sustainability:</strong> Long-term thinking about AI\'s impact</li>
</ul>

<h2>What You Can Do</h2>
<ol>
<li>Question the data you use for training models</li>
<li>Test your AI systems across diverse populations</li>
<li>Be transparent about limitations and biases</li>
<li>Involve communities affected by your AI</li>
<li>Advocate for ethical AI policies</li>
</ol>

<p>The future of AI in Africa depends on choices we make today. Let\'s build responsibly.</p>',
1, 1,
'["Ethics", "AI", "Africa", "Responsibility", "Society"]',
489, 0, 'published', DATE_SUB(NOW(), INTERVAL 8 DAY), DATE_SUB(NOW(), INTERVAL 8 DAY), NOW());

-- ============================================
-- 3. SAMPLE COMMENTS
-- ============================================

-- Get the first blog post ID for comments
SET @post_id = (SELECT id FROM blog_posts ORDER BY created_at ASC LIMIT 1);

INSERT INTO blog_comments (post_id, user_id, content, status, created_at) VALUES
(@post_id, 1, 'Great article! This really inspired me to start learning AI. Ghana is definitely leading the way in tech innovation.', 'approved', DATE_SUB(NOW(), INTERVAL 2 HOUR)),
(@post_id, 1, 'I\'ve been following the AI scene in Africa for years, and it\'s amazing to see how far we\'ve come. Thanks for sharing!', 'approved', DATE_SUB(NOW(), INTERVAL 5 HOUR)),
(@post_id, 1, 'As someone just starting in AI, this gives me so much hope. Can\'t wait to join the next cohort at Nebatech!', 'approved', DATE_SUB(NOW(), INTERVAL 1 DAY));

-- ============================================
-- 4. VERIFICATION QUERIES
-- ============================================

-- Check categories
SELECT 'Categories Created:' as Info, COUNT(*) as Count FROM blog_categories;

-- Check posts
SELECT 'Blog Posts Created:' as Info, COUNT(*) as Count FROM blog_posts;

-- Check featured post
SELECT 'Featured Posts:' as Info, COUNT(*) as Count FROM blog_posts WHERE is_featured = 1;

-- Check comments
SELECT 'Comments Created:' as Info, COUNT(*) as Count FROM blog_comments;

-- List all posts
SELECT 
    title, 
    slug, 
    category_id,
    views,
    is_featured,
    status,
    DATE_FORMAT(published_at, '%Y-%m-%d') as published
FROM blog_posts 
ORDER BY published_at DESC;

-- ============================================
-- SUCCESS MESSAGE
-- ============================================

SELECT '✅ Blog sample data seeded successfully!' as Message,
       '10 blog posts created' as Posts,
       '6 categories created' as Categories,
       '3 sample comments added' as Comments;
