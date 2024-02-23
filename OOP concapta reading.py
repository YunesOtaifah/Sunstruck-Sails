import numpy as np

def demonstrate_arrays():
    # One-Dimensional Array (1D)
    arr_1d = np.array([1, 2, 3, 4, 5])
    print("One-Dimensional Array:")
    print(arr_1d)
    print()

    # Two-Dimensional Array (2D)
    arr_2d = np.array([[1, 2, 3], [4, 5, 6]])
    print("Two-Dimensional Array:")
    print(arr_2d)
    print()

    # Three-Dimensional Array (3D)
    arr_3d = np.array([[[1, 2], [3, 4]], [[5, 6], [7, 8]]])
    print("Three-Dimensional Array:")
    print(arr_3d)
    print()

    # Accessing elements and performing operations
    print("Accessing elements and performing operations:")
    print("Element at (0, 1) in arr_2d:", arr_2d[0, 1])
    print("Sum of all elements in arr_1d:", np.sum(arr_1d))
    print("Transposed arr_2d:")
    print(np.transpose(arr_2d))
    print()

    # Broadcasting in NumPy
    print("Broadcasting in NumPy:")
    arr_broadcast = arr_1d + 10
    print("Original 1D array:", arr_1d)
    print("Broadcasted 1D array (added 10 to each element):", arr_broadcast)

if __name__ == "__main__":
    demonstrate_arrays()
