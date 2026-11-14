// Lettern Docs: keep the sidebar's scroll position from page to page — every link is a full page load,
// and a long sidebar should not jump back to the top. (Behavior the builder has no setting for.)
const nav = document.getElementById('sidebar')

if (nav) {
  try {
    nav.scrollTop = Number(sessionStorage.getItem('cms-docs-sidebar')) || 0
  } catch {}

  addEventListener('pagehide', () => {
    try {
      sessionStorage.setItem('cms-docs-sidebar', String(nav.scrollTop))
    } catch {}
  })
}
