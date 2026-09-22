export default {
    content: ['./resources/**/*.blade.php', './app/Livewire/**/*.php'],
    theme: {
        extend: {
            keyframes: {
                float: {
                    '0%, 100%': {transform: 'translateY(0) rotate(0deg)'},
                    '50%': {transform: 'translateY(-18px) rotate(8deg)'},
                },
                bgshift: {
                    '0%, 100%': {backgroundPosition: '0% 50%'},
                    '50%': {backgroundPosition: '100% 50%'},
                },
                pop: {
                    '0%': {transform: 'scale(0.6)', opacity: '0'},
                    '60%': {transform: 'scale(1.15)', opacity: '1'},
                    '100%': {transform: 'scale(1)', opacity: '1'},
                },
                sunpulse: {
                    '0%, 100%': {transform: 'scale(1) rotate(0deg)'},
                    '50%': {transform: 'scale(1.08) rotate(4deg)'},
                },
                drift: {
                    '0%': {transform: 'translateX(-20vw)'},
                    '100%': {transform: 'translateX(110vw)'},
                },
                sway: {
                    '0%, 100%': {transform: 'rotate(-4deg)'},
                    '50%': {transform: 'rotate(4deg)'},
                },
                wobble: {
                    '0%, 100%': {transform: 'rotate(0deg) scale(1)'},
                    '25%': {transform: 'rotate(-10deg) scale(1.08)'},
                    '75%': {transform: 'rotate(10deg) scale(1.08)'},
                },
                'mascot-jump': {
                    '0%, 100%': {transform: 'translateY(0) scale(1)'},
                    '40%': {transform: 'translateY(-28px) scale(1.15) rotate(6deg)'},
                    '60%': {transform: 'translateY(-14px) scale(1.08) rotate(-6deg)'},
                },
                'mascot-breathe': {
                    '0%, 100%': {transform: 'translateY(0) scale(1)'},
                    '50%': {transform: 'translateY(-5px) scale(1.02)'},
                },
                'rubber-band': {
                    '0%': {transform: 'scale(1)'},
                    '30%': {transform: 'scaleX(1.3) scaleY(0.7)'},
                    '40%': {transform: 'scaleX(0.75) scaleY(1.25)'},
                    '50%': {transform: 'scaleX(1.15) scaleY(0.85)'},
                    '65%': {transform: 'scaleX(0.95) scaleY(1.05)'},
                    '100%': {transform: 'scale(1)'},
                },
                kenburns: {
                    '0%, 100%': {transform: 'scale(1.02) translate(0, 0)'},
                    '50%': {transform: 'scale(1.08) translate(-1%, -1%)'},
                },
            },
            animation: {
                float: 'float 6s ease-in-out infinite',
                bgshift: 'bgshift 12s ease-in-out infinite',
                pop: 'pop 0.4s ease-out',
                sunpulse: 'sunpulse 7s ease-in-out infinite',
                'drift-slow': 'drift 50s linear infinite',
                'drift-mid': 'drift 35s linear infinite',
                'drift-fast': 'drift 22s linear infinite',
                sway: 'sway 5s ease-in-out infinite',
                wobble: 'wobble 0.6s ease-in-out infinite',
                'mascot-jump': 'mascot-jump 0.8s ease-in-out',
                'mascot-breathe': 'mascot-breathe 3s ease-in-out infinite',
                'rubber-band': 'rubber-band 0.6s ease-out',
                kenburns: 'kenburns 24s ease-in-out infinite alternate',
            },
        },
    },
    plugins: [],
};
