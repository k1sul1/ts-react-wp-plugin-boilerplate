import '../styles/admin.scss'

/**
 * This file is built into an UMD bundle. The default export will
 * be exposed under window.myEmptyPlugin, if the resulting file is loaded via
 * <script> tag. You can also use modern import syntax to import the built file.
 */
export default (() => {
  const hello = () => console.log('Hello from myEmptyPlugin admin.ts!')

  hello()

  // Exposed methods:
  return {
    hello,
  }
})()
