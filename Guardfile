# A sample Guardfile
# More info at https://github.com/guard/guard#readme

guard 'sass', :input => 'public/css'

# guard 'process', :name => 'Minify application javascript', :command => 'juicer merge public/js/functions.js --force -s' do
#   watch %r{public/js/models/(.+)\.js}
# end

guard 'process', :name => 'Compile CoffeeScript', :command => 'rake compile' do
  watch %r{public/js/(.+)\.coffee}
  watch %r{public/js/(.+)\.js}
  ignore %r{public/js/functions.js}
end

# guard 'coffeescript', :input => 'public/js/functions.coffee'