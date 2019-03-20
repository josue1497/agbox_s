        <div class="row">
            {{ replace_groups }}
        </div>
        <script>
            function affiliateGroup(form_data) {
                var url = "{{ api_url }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form_data,
                    success: function(_data) {
                        alert('exitoso');
                    }
                });
                return false;

            }
        </script> 