---
title: JavaScript fetch() Basics — GET and POST JSON
description: Fetch JSON APIs with error handling and request cancellation via AbortController.
category: javascript
order: 10
tags: [javascript, fetch, api]
updated: 2026-10-06
related: [javascript/dom-without-framework]
---

## GET JSON

```js
const res = await fetch('https://api.getmy.name/v1/profile');
if (!res.ok) throw new Error('HTTP ' + res.status);
const data = await res.json();
console.log(data);
```

`fetch()` only rejects on network failure — **always check `res.ok` yourself**.

## POST JSON

```js
const res = await fetch('/api/contact', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ name: 'Ada', message: 'Hi!' }),
});
```

## Cancel a request

```js
const ctrl = new AbortController();
setTimeout(() => ctrl.abort(), 5000); // 5s timeout

const res = await fetch('/api/slow', { signal: ctrl.signal });
```

## Error pattern

```js
try {
  const data = await loadData();
  render(data);
} catch (err) {
  showNotice(err.name === 'AbortError' ? 'Timed out' : 'Failed to load');
}
```
