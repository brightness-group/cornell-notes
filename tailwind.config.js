module.exports = {
    content: [
        "./resources/**/*.blade.php",
        './resources/views/**/*.html',
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    // The various configurable Tailwind configuration files.
    presets: [
        require('tailwindcss/defaultConfig'),
        require('./tailwind.config.typography.js'),
        require('./tailwind.config.peak.js'),
        require('./tailwind.config.site.js'),
    ],

    // Uncomment the next line to enable class based dark mode: https://peak.1902.studio/features/dark-mode.html.
    // darkMode: 'class',

    mode: 'jit',

    safelist: [
        {
            pattern: /bg-(red|green|blue|orange)-(100|200|300|400|500|600|700)/,
        },
    ],
    theme: {
        extend: {
            spacing: {
                'header-height': '91px',
            },
            screens: {
              'lap-touch': {'max': '1250px'},  
              'ipad': {'max': '1024px'},
              'ipad-1': {'max': '1023px'},
              'ipadx': {'max': '991px'},
              'mobile': {'max': '767px'},
            }
        },
        colors: {
            transparent: 'transparent',
            'light-black': '#0B0500',
            'font-black': '#151515',
            'white': '#ffffff',
            'light-white': '#FCFAFA',
            'primary': '#002FBD',
            'secondary': '#072684',
            'brown': '#7A6563',
            'cus-gray': '#898989',
            'light-gray': '#C8D3D5',
            'very-light-gray': '#F9F9F9'
        },
        fontFamily: {
            'itc': ['itc-avant-garde-gothic-pro', 'sans-serif']
        },
        fontWeight: {
            light: 300,
            medium: 500,
            bold: 700
        },
        minWidth: {
            '44': '176px',
        }
    }
};
