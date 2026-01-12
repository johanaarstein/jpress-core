import type { Plugin, RollupOptions } from 'rollup'

import { swc, minify } from 'rollup-plugin-swc3'

const plugins = (): Plugin[] => {
    return [
      swc(), minify(),
    ]
  },

  config: RollupOptions[] = [
    {
      input: './src/jp-includes/js/admin.ts',
      onwarn(warning, warn) {
        if (warning.code === 'THIS_IS_UNDEFINED') {
          return
        }
        warn(warning)
      },
      output: {
        file: './src/jp-includes/js/admin.min.js',
        format: 'iife',
      },
      plugins: plugins(),
    },
  ]

export default config
