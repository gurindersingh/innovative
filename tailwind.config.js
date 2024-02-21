import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import aspectRatio from '@tailwindcss/aspect-ratio';

export default {

    content: [
        './resources/views/**/*.blade.php'
    ],

    /**
     * Configure theme
     */
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    /**
     * Add Tailwind plugins
     */
    plugins: [forms, aspectRatio],

}