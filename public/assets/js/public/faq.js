document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.q-text');
    
    questions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('.toggle-icon');
            
            const isOpen = answer.style.display === 'block';

            document.querySelectorAll('.a-text').forEach(a => {
                a.style.display = 'none';
            });
            document.querySelectorAll('.toggle-icon').forEach(i => {
                i.style.transform = 'rotate(0deg)';
            });
            if (!isOpen) {
                answer.style.display = 'block';
                answer.animate([
                    { opacity: 0, transform: 'translateY(-10px)' },
                    { opacity: 1, transform: 'translateY(0)' }
                ], { duration: 200, fill: 'forwards' });
                
                if (icon) icon.style.transform = 'rotate(180deg)';
            }
        });
    });
});