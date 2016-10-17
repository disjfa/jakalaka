<script>
    export default{
        params: ['styles'],
        bind: function (el) {
            $(el).draggable({
                stop: function (event, ui) {
                    if (self.params.styles) {
                        self.params.styles.left = ui.position.left;
                        self.params.styles.top = ui.position.top;
                    }
                }
            });

            $(el).resizable({
                stop: function (event, ui) {
                    if (self.params.styles) {
                        self.params.styles.width = ui.size.width;
                        self.params.styles.height = ui.size.height;
                    }
                }
            });
        }
    }
</script>
