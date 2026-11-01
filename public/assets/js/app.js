// assets/js/app.js
// Small helpers shared by every page.
// CENTRALIZE: copy to public/assets/js/ and load it ONCE in layouts/app.blade.php:
// <script src="{{ asset('assets/js/app.js') }}" defer></script>
//
// PROTOTYPE vs LARAVEL: the messages, required-field checks and duplicate checks below only
// SIMULATE what the server will do later. In Laravel the controller validates and sets the message
// (->with('success', '...')), and partials/flash.blade.php prints it. Nothing here is saved anywhere,
// so everything resets when you reload the page.

document.addEventListener('DOMContentLoaded', function () {

  // ===== Start: Draw icons =====
  // Turns every <i data-lucide="name"></i> into an icon.
  if (window.lucide) { lucide.createIcons(); }
  // ===== End: Draw icons =====

  // ===== Start: Flash messages (success / error) =====
  // showMessage('success', 'Saved.') puts a message at the top of the page. It is NOT in the HTML,
  // so a reload makes it disappear. It also closes itself after 6 seconds.
  function showMessage(type, text) {
    var box = document.getElementById('flash-messages');
    if (!box) { return; }
    var ok = type === 'success';
    var el = document.createElement('div');
    el.className = 'flex items-start gap-3 rounded-lg border px-4 py-3 text-sm ' +
      (ok ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : 'border-red-200 bg-red-50 text-red-800');
    el.innerHTML = '<i data-lucide="' + (ok ? 'check-circle-2' : 'alert-circle') + '" class="w-5 h-5 shrink-0"></i>' +
      '<span class="flex-1"></span>' +
      '<button type="button" class="opacity-60 hover:opacity-100" aria-label="Close"><i data-lucide="x" class="w-4 h-4"></i></button>';
    el.querySelector('span').textContent = text;
    el.querySelector('button').addEventListener('click', function () { el.remove(); });
    box.innerHTML = '';
    box.appendChild(el);
    if (window.lucide) { lucide.createIcons(); }
    window.scrollTo({ top: 0, behavior: 'smooth' });
    setTimeout(function () { el.remove(); }, 6000);
  }
  // ===== End: Flash messages (success / error) =====

  // ===== Start: Save forms (required fields, duplicates, success message) =====
  // Usage: <form data-success="Student saved successfully."> with fields marked data-required.
  // Optional: data-reset (clear the form after success), data-lock-after (disable the button after success),
  // data-dup-pairs="0:1,2:3" (student:course pairs that already exist) or data-dup-courses="0,2" (course ids
  // already registered) together with data-dup-message="...".  {course} in data-success is replaced by the course title.
  document.querySelectorAll('form[data-success]:not([data-confirm])').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault(); // prototype only: there is no server to send the form to

      // 1) Required fields
      var missing = 0;
      form.querySelectorAll('[data-required]').forEach(function (field) {
        var empty = field.value.trim() === '';
        field.classList.toggle('is-invalid', empty);
        if (empty) { missing++; }
      });
      if (missing > 0) {
        showMessage('error', 'Please fill in all the required fields.');
        return;
      }

      // 2) Email format
      var badEmail = false;
      form.querySelectorAll('input[type="email"]').forEach(function (field) {
        var valid = /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(field.value.trim());
        field.classList.toggle('is-invalid', !valid);
        if (!valid) { badEmail = true; }
      });
      if (badEmail) {
        showMessage('error', 'Please enter a valid email address.');
        return;
      }

      // 3) Duplicate registration (SIMULATION: Laravel does the real check with Rule::unique + a unique index)
      if (form.dataset.dupPairs !== undefined) {
        var key = form.elements['student_id'].value + ':' + form.elements['course_id'].value;
        var pairs = form.dataset.dupPairs ? form.dataset.dupPairs.split(',') : [];
        if (pairs.indexOf(key) > -1) { showMessage('error', form.dataset.dupMessage); return; }
        pairs.push(key);
        form.dataset.dupPairs = pairs.join(',');
      }
      if (form.dataset.dupCourses !== undefined) {
        var cid = form.elements['course_id'].value;
        var courses = form.dataset.dupCourses ? form.dataset.dupCourses.split(',') : [];
        if (courses.indexOf(cid) > -1) { showMessage('error', form.dataset.dupMessage); return; }
        courses.push(cid);
        form.dataset.dupCourses = courses.join(',');
      }

      // 4) Success
      var titleEl = document.getElementById('course-title');
      showMessage('success', form.dataset.success.replace('{course}', titleEl ? titleEl.textContent : 'the course'));
      if (form.hasAttribute('data-reset')) { form.reset(); }
      if (form.hasAttribute('data-lock-after')) {
        var button = form.querySelector('[type="submit"]');
        button.disabled = true;
        button.textContent = 'Registered';
        button.classList.add('opacity-60', 'cursor-not-allowed');
      }
    });

    // Remove the red border as soon as the user starts fixing a field
    form.addEventListener('input', function (e) { e.target.classList.remove('is-invalid'); });
    form.addEventListener('change', function (e) { e.target.classList.remove('is-invalid'); });
  });
  // ===== End: Save forms (required fields, duplicates, success message) =====

  // ===== Start: Delete / remove buttons (confirm, then message) =====
  // Usage: <form data-confirm="Delete this student?" data-success="Student deleted successfully.">
  // PROTOTYPE: removes the table row on screen. LARAVEL: the controller deletes the record and redirects with ->with('success', ...).
  document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!confirm(form.dataset.confirm)) { return; }
      var row = form.closest('tr');
      if (row) { row.remove(); }
      showMessage('success', form.dataset.success || 'Done.');
    });
  });
  // ===== End: Delete / remove buttons (confirm, then message) =====

  // ===== Start: Role save buttons (User access page) =====
  // Forms with data-success but no required fields simply show their success message.
  // (They are handled by the Save forms block above.)
  // ===== End: Role save buttons (User access page) =====

  // ===== Start: Table search box =====
  // Usage: <input data-filter="#table-id"> hides rows that do not match what you type.
  document.querySelectorAll('input[data-filter]').forEach(function (input) {
    var rows = document.querySelectorAll(input.dataset.filter + ' tbody tr');
    input.addEventListener('input', function () {
      var q = input.value.toLowerCase();
      rows.forEach(function (row) {
        row.style.display = row.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none';
      });
    });
  });
  // ===== End: Table search box =====

});
