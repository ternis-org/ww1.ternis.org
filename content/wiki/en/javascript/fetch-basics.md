---
title: JavaScript fetch() Basics — Asynchronous HTTP, JSON, and Error Handling
description: Complete beginner guide to the modern JavaScript fetch API, handling HTTP errors with res.ok, POSTing JSON payloads, and request timeouts with AbortController.
category: javascript
order: 10
tags: [javascript, fetch, api, json, frontend, web-development, async]
updated: 2026-10-06
related: [php/getting-started-83, css/layout-grid-flexbox]
---

## What is the `fetch()` API?

The **`fetch()`** API is the native web standard interface for making asynchronous HTTP requests in modern browsers and server-side runtimes (Node.js, Deno, Bun).

It replaces legacy `XMLHttpRequest` (XHR) with clean, promise-based syntax designed to work naturally with `async` and `await`.

---

## 1. The Crucial Beginner Trap: `res.ok`

The single most common mistake beginners make with `fetch()`:

> **`fetch()` only rejects a Promise on a true network failure** (such as being offline, DNS resolution failure, or a CORS restriction).

If the server responds with **`HTTP 404 Not Found`** or **`HTTP 500 Internal Server Error`**, `fetch()` **still resolves successfully**! You must check `res.ok` manually:

```javascript
async function fetchUserProfile(userId) {
  try {
    const response = await fetch(`https://api.example.com/users/${userId}`);

    // Check if the HTTP status code is in the 200–299 range
    if (!response.ok) {
      throw new Error(`Server returned error: ${response.status} ${response.statusText}`);
    }

    // Parse the JSON response body
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Fetch operation failed:', error.message);
    throw error;
  }
}
```

### Breakdown of the response object

- `response.ok`: Boolean flag. Returns `true` if `status` is between 200 and 299; `false` otherwise.
- `response.status`: Numeric HTTP response code (e.g. `200`, `404`, `500`).
- `await response.json()`: Asynchronously parses the incoming byte stream as JSON.

---

## 2. Sending Data with POST Requests

To submit data to an API endpoint (e.g. creating a record or logging in):

```javascript
async function createPost(title, content) {
  const payload = { title, content };

  const response = await fetch('https://api.example.com/posts', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      // 'Authorization': 'Bearer YOUR_TOKEN_HERE',
    },
    body: JSON.stringify(payload),
  });

  if (!response.ok) {
    throw new Error(`Failed to create post. Status: ${response.status}`);
  }

  return await response.json();
}
```

### Options object breakdown

- `method: 'POST'`: Specifies the HTTP request verb (e.g. `POST`, `PUT`, `PATCH`, `DELETE`).
- `headers`: HTTP headers sent to the server.
  - `'Content-Type': 'application/json'`: Tells the backend that the request body is formatted as a JSON string.
  - `'Accept': 'application/json'`: Informs the backend that the client expects a JSON response.
- `body: JSON.stringify(payload)`: Converts the JavaScript object into a valid JSON string.

---

## 3. Canceling Requests and Setting Timeouts with `AbortController`

By default, `fetch()` has no built-in timeout—if a backend hangs, your request can remain open indefinitely.

Use an **`AbortController`** to automatically cancel slow requests after a timeout threshold:

```javascript
async function fetchWithTimeout(url, timeoutMs = 5000) {
  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), timeoutMs);

  try {
    const response = await fetch(url, {
      signal: controller.signal,
    });

    if (!response.ok) throw new Error(`HTTP ${response.status}`);
    return await response.json();
  } catch (error) {
    if (error.name === 'AbortError') {
      throw new Error(`Request timed out after ${timeoutMs}ms`);
    }
    throw error;
  } finally {
    // Clear the timer once the request finishes to avoid memory leaks
    clearTimeout(timeoutId);
  }
}
```

### How AbortController works

- `new AbortController()`: Creates a controller instance with an associated `signal`.
- `signal: controller.signal`: Binds the fetch request to that controller.
- `controller.abort()`: Immediately halts the network request and causes the fetch Promise to reject with an `AbortError`.
