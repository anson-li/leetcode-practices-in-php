# Design Concept 

    We want to build a new feature for treetime.ca that would allow us automatically, in real time,
    calculate an appropriate shipping charge to any destination address for any number or
    combination of items in a customer’s shopping cart.

    We have access to Canada Post’s shipping API. We can use this API to calculate the cost of
    shipping a box of known dimensions to any postal code.

    So to make this work we need to write code to estimate how many of what size of boxes
    will be required to ship the customer’s entire order to their postal code and then run that
    information through the Canada Post shipping API to determine the correct shipping charge.

    Undercharging for shipping could cost us a lot of money but overcharging could cause people to
    abandon their purchase altogether. So we need to get this right.

    We have 10 sizes of boxes. The cheapest shipping is achieved by using the fewest number of
    the smallest boxes. For the purposes of this exercise, the cost of shipping two boxes is always
    higher than using one box (regardless of the size of the boxes).

# References
[Solving the box selection algorithm](https://medium.com/the-chain/solving-the-box-selection-algorithm-8695df087a4)
[Knapsack problem](https://en.wikipedia.org/wiki/Knapsack_problem)
[Shotput packing algorithm](https://medium.com/the-chain/efficiency-of-the-shotput-packing-algorithm-a690e914d49c)
[First fit descending](https://en.wikipedia.org/wiki/Bin_packing_problem)
[pyShipping](https://github.com/hudora/pyShipping/tree/master/pyshipping)

# Notes
* Take into factor length, width, and height, and weight.
* Take into factor bundles of 1, 3, 5, 10, and bulk trees (all packaged together with no bundling)? Bundles take up less space but have greater weight.
* Also pass the postal code and return a cleaned postal code via normalizeAndValidate($zipCode), erroring out if invalid zip code and returning a custom exception

# Assumptions
* Selling at least three types of plants for test purposes.
* Packaging with 10 sizes of boxes
* Priority of shipping is use largest size first, before swapping to a new box (eg. 1 box size 10 is cheaper than 2 size box 1). 
* Packaging bundles of different plants is done via bundles (!) So, you'll need to double the packaging for two bulk items, despite having the possibility of packaging both itmes together in the same package (for usability purposes).
* The width and the height of the packages are variable (eg. you can stack multiple across the width and height), but the length is not. In other words, you cannot stack the plants lengthwise - the most you can stack lengthwise is 1.
* Each plant is broken up into four components - plant, packaging container (if single plant only!), dirt, and wrapping.
  * Boxes are fixed and only used for single plants, but provide a fixed height and width - doesn't affect length.
  * Bulk items only wrap the entire package, no need to do individual packaging. Bulk items require more space for dirt - ensure longer boxes are used for bulk items.
* We /will/ need to split boxes that have too many items. For these items, we'll have to calculate the max possible size that can be fit into the largest box, and remove that many items from the item set. Then, we'd continue with the next set.
* Maybe, for solo boxes, consider flipping the containers in order to maximise space usage? Maybe as a potential improvement to the core software.
* There is an upper limit of items to be shipped (we will say +10000). Once this limit is reached an exception is raised for this specific function - perhaps consider an improvement where users are alerted to contact directly for larger sales.
* Maybe calculate across different parameters -eg. include tracking, include same-day shipping, etc.
* Remember there are some boxes that are long and narrow, and some that are short and wide. We'll have to compile a list of the most viable boxes for each, and continue to use the smallest box available as long as possible.
* For each box packed, unless it's the largest box possible, try to 'overload' that box as box size is priority over quantity.
* Maybe treat cylindrical items as boxes, in order to better 'fill' the 2d space. 
* Do we treat boxes as 2d arrays, separating by inches, for better optimization? You'd have to, or else one could 'max' out on the width and the box wouldn't fill any more.
* Is weight a concern? From the look of the bulk items it doesn't look like it's a significant issue for the boxes, but we can include it.

# The box packing problem
* **IMPORTANT:** once you've grabbed the items, go by largest to smallest! By doing so, you remove the problem of retrofitting/refitting various packages 
* Basically, there's a problem with treating boxes as a 3d space without assigning packing parameters. The problem is, if there's empty space 'below' a larger package, it /could/ be filled with another item but there wouldn't be a 
* Do you rotate packages? Do you sort packages first? The problem is debated endlessly by academics...

# Modified First Fit Decreasing (MFFD) - From Wikipedia
Improves on FFD for items larger than half a bin by classifying items by size into four size classes large, medium, small, and tiny, corresponding to items with size > 1/2 bin, > 1/3 bin, > 1/6 bin, and smaller items respectively. Then it proceeds through five phases:

    * Allot a bin for each large item, ordered largest to smallest.
    * Proceed forward through the bins. On each: If the smallest remaining medium item does not fit, skip this bin. Otherwise, place the largest remaining medium item that fits.
    * Proceed backward through those bins that do not contain a medium item. On each: If the two smallest remaining small items do not fit, skip this bin. Otherwise, place the smallest remaining small item and the largest remaining small item that fits.
    * Proceed forward through all bins. If the smallest remaining item of any size class does not fit, skip this bin. Otherwise, place the largest item that fits and stay on this bin.
    * Use FFD to pack the remaining items into new bins.

# Accouting for human error
* A machine can pack a package perfectly to specifications, but there's a lot to account for human error, including both suboptimal packing and variable plant growth/sizing. For the purposes of this example, we'll set the human error to 12%.

# Packing algorithm
* For each item:
  * Identify the quantity of each item that's being sent.
    * For single items, use length of item + width and height of container. Can override width and height.
    * For nonbulk multiple items, use length of item + width and height of bundle + 5% for wrapping and error.
      * Bundle calculation: bundles are always wrapped in a cylindrical fashion. So, need ot find algorithm to solve for wrapping a bundle in a cylinder. Cylinders are pi r^2 * h. 
    * For bulk items, use length of item * 20% for dirt packing, + width and height of items stacked in a cube fashion + 2cm? for plastic packaging.
  * For each item, we fill to the largest box first, then if the box is full /then/ we move to the next box. We're going to do the easy thing and separate the packages once packed, so if the box can't add the w + h of the next item then we move to the next largest box, etc. Once we've hit the largest box and it doesn't fit, then we keep the previous box size and we create a new 'box' to hold the new shipment.
    * This cascades for multiple items - for each item, check if it can be fit into a previous box in the list. If it fits into any box then 'upgrade' that box and insert the item into that box.
    * This means that the array will have to carry two items - the box size currently used, and the remaining w/h that can be fit into that box.

# Calculations required
* How to find the cylindrical volume given item w/h
* How to find the cube volume given item w/h
* Sort operation for box size and viable box array generation
  * 'Packing problem'

# Process
Given a zip code and which items to ship:
normalizeAndValidate($zipCode)
calculateBulk(int[] $itemIds, string $zipCode)
For each item, get the item dimensions based on quantity
Break down item into batches of 1, 3, 5 or 10 depending on quantity. If over 20, use bulk sizing. 
