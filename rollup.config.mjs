import { swc, minify } from 'rollup-plugin-swc3'

const plugins = () => {
  return [
    swc(),
    minify(),
  ]
}

export default [
  {
    input: "./src/jp-includes/js/admin.ts",
    output: {
      file: "./src/jp-includes/js/admin.min.js",
      format: "iife",
    },
    plugins: plugins(),
    onwarn(warning, warn) {
      if (warning.code === "THIS_IS_UNDEFINED") return;
      warn(warning);
    },
  },
];
