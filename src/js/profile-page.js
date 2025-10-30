

(function() {
  function ready(fn) {
    if (document.readyState !== 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }

  window.logout = function() {
    if (confirm('Are you sure you want to logout?')) {
      window.location.href = '../backend/logout.php';
    }
  };

  ready(function() {
    var editLink = document.getElementById('edit-profile-link');
    if (editLink) {
      editLink.addEventListener('click', function(e) {
        e.preventDefault();
        var form = document.querySelector('#profile-info-form');
        if (form) {
          form.scrollIntoView({ behavior: 'smooth' });
          var firstInput = form.querySelector('input[name="first_name"]');
          if (firstInput) firstInput.focus();
        }
      });
    }

    var showBtn = document.getElementById('show-change-password');
    var sidebarBtn = document.getElementById('sidebar-change-password');
    var profileBtn = document.getElementById('sidebar-profile');
    var form = document.getElementById('change-password-form');
    var profileForm = document.getElementById('profile-info-form');

    function showChangePassword() {
      if (form) {
        form.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth' });
      }
      if (profileForm) {
        profileForm.style.display = 'none';
      }
    }

    function showProfileForm() {
      if (form) {
        form.style.display = 'none';
      }
      if (profileForm) {
        profileForm.style.display = 'block';
        profileForm.scrollIntoView({ behavior: 'smooth' });
      }
    }

    if (showBtn) {
      showBtn.addEventListener('click', function() {
        showChangePassword();
      });
    }
    if (sidebarBtn) {
      sidebarBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showChangePassword();
      });
    }
    if (profileBtn) {
      profileBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showProfileForm();
      });
    }

    var links = document.querySelectorAll('.sidebar-link');
    var sections = {
      'sidebar-profile': document.getElementById('section-profile'),
      'sidebar-cart': document.getElementById('section-cart'),
      'sidebar-orders': document.getElementById('section-orders'),
      'sidebar-change-password': document.getElementById('section-change-password'),
      'sidebar-addresses': document.getElementById('section-addresses')
    };

    function setActive(linkId) {
      links.forEach(function(link) {
        if (link.id === linkId) {
          link.classList.add('bg-pink-100', 'text-pink-600', 'font-medium');
        } else {
          link.classList.remove('bg-pink-100', 'text-pink-600', 'font-medium');
        }
      });
    }

    function showSection(linkId) {
      Object.keys(sections).forEach(function(id) {
        if (sections[id]) {
          sections[id].style.display = (id === linkId) ? 'block' : 'none';
        }
      });
      setActive(linkId);
    }

    links.forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        showSection(link.id);
      });
    });

    showSection('sidebar-profile');

    try {
      var params = new URLSearchParams(window.location.search);
      var missingAddress = params.get('error') === 'missing_address' || params.get('missing_address') === '1';
      if (missingAddress) {
        showSection('sidebar-addresses');
        var addressSection = document.getElementById('section-addresses');
        var warning = document.getElementById('address-warning');
        if (warning) {
          warning.innerHTML = '<div class="rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-yellow-800">' +
            '<strong class="font-semibold">Address required:</strong> Please complete your delivery address before placing an order.' +
          '</div>';
          warning.style.display = 'block';
        }
        if (addressSection) {
          addressSection.scrollIntoView({ behavior: 'smooth' });
          var firstField = addressSection.querySelector('input[name="street_address"]');
          if (firstField) firstField.focus();
        }
      }
    } catch (e) {
    }
  });
})();
